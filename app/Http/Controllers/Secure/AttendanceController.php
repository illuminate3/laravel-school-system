<?php

namespace App\Http\Controllers\Secure;

use App\Events\Attendance\AttendanceCreated;
use App\Http\Requests\Secure\AddAttendanceRequest;
use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\AttendanceGetRequest;
use App\Models\Attendance;
use App\Models\Option;
use App\Models\ParentStudent;
use App\Models\Semester;
use App\Models\SmsMessage;
use App\Models\Student;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use App\Repositories\OptionRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TimetableRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Session;
use Datatables;
use Illuminate\Support\Collection;
use SMS;

class AttendanceController extends SecureController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var TimetableRepository
     */
    private $timetableRepository;
    /**
     * @var AttendanceRepository
     */
    private $attendanceRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * AttendanceController constructor.
     * @param StudentRepository $studentRepository
     * @param TimetableRepository $timetableRepository
     * @param AttendanceRepository $attendanceRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                TimetableRepository $timetableRepository,
                                AttendanceRepository $attendanceRepository,
                                OptionRepository $optionRepository)
    {
        parent::__construct();

        $this->studentRepository = $studentRepository;
        $this->timetableRepository = $timetableRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'attendance');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('attendance.attendances');
        $students = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name,
                ];
            })->pluck('name', 'id')->toArray();

        $attendance_type = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'attendance_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            })->pluck('title', 'value')->toArray();

        $hour_list = $this->timetableRepository->getAll()
            ->with('teacher_subject')
            ->get()
            ->filter(function ($timetable) {
                return (isset($timetable->teacher_subject->teacher_id) &&
                    $timetable->teacher_subject->teacher_id == $this->user->id &&
                    $timetable->week_day == date('N', strtotime("- 1 day", strtotime('now'))) &&
                    $timetable->teacher_subject->student_group_id == session('current_student_group'));
            })
            ->map(function ($timetable) {
                return [
                    'id' => $timetable->hour,
                    'hour' => $timetable->hour,
                ];
            })->pluck('hour', 'id')->toArray();

        return view('attendance.index', compact('title', 'students', 'attendance_type', 'hour_list'));
    }

    public function hoursForDate(AttendanceGetRequest $request)
    {
        $request->date = Carbon::createFromFormat(Settings::get('date_format'), $request->date);

        return $hour_list = $this->timetableRepository->getAll()
            ->with('teacher_subject')
            ->get()
            ->filter(function ($timetable) use ($request) {
                return (isset($timetable->teacher_subject->teacher_id) &&
                    $timetable->teacher_subject->teacher_id == $this->user->id &&
                    $timetable->week_day == date('N', strtotime($request->date)) &&
                    $timetable->teacher_subject->student_group_id == session('current_student_group'));
            })
            ->map(function ($timetable) {
                return [
                    'id' => $timetable->hour,
                    'hour' => $timetable->hour,
                ];
            })->pluck('hour', 'id')->toArray();
    }

    public function addAttendance(AddAttendanceRequest $request)
    {
        $date = date_format(date_create_from_format(Settings::get('date_format'), $request->date), 'd-m-Y');
        $semestar = Semester::where(function ($query) use ($date) {
            $query->where('start', '>=', $date)
                ->where('school_year_id', '=', session('current_school_year'));
        })->orWhere(function ($query) use ($date) {
            $query->where('end', '<=', $date)
                ->where('school_year_id', '=', session('current_school_year'));
        })->first();

        $subject = $hour_list = $this->timetableRepository->getAll()
            ->with('teacher_subject')
            ->get()
            ->filter(function ($timetable) use ($date) {
                return (isset($timetable->teacher_subject->teacher_id) &&
                    $timetable->teacher_subject->teacher_id == $this->user->id &&
                    $timetable->week_day == date('N', strtotime($date)) &&
                    $timetable->teacher_subject->student_group_id == session('current_student_group'));
            })
            ->map(function ($timetable) {
                return [
                    'id' => $timetable->teacher_subject->subject_id,
                ];
            })->first();
        if (isset($subject['id'])) {
            foreach ($request['students'] as $student_id) {
                foreach ($request['hour'] as $hour) {
                    $attendance = new Attendance($request->except('students', 'hour'));
                    $attendance->teacher_id = $this->user->id;
                    $attendance->student_id = $student_id;
                    $attendance->semester_id = isset($semestar->id) ? $semestar->id : 1;
                    $attendance->subject_id = $subject['id'];
                    $attendance->hour = $hour;
                    $attendance->school_year_id = session('current_school_year');
                    $attendance->save();

                    //event(new AttendanceCreated($attendance));

                    if (Settings::get('automatic_sms_mark') == 1 && Settings::get('sms_driver') != "" && Settings::get('sms_driver') !='none') {
                        $parents_sms = ParentStudent::join('students', 'students.user_id', '=', 'parent_students.user_id_student')
                            ->join('users', 'users.id', '=', 'parent_students.user_id_parent')
                            ->where('students.id', $student_id)
                            ->where(function ($q) {
                                $q->where('users.get_sms', 1);
                                $q->orWhereNull('users.get_sms');
                            })
                            ->select('users.*')->get();
                        foreach ($parents_sms as $item) {
                            $student = User::find(Student::find($student_id)->user_id);
                            $option_type = Option::find($request->option_id);

                            $sms_text = trans('attendance.student') . ": " . $student->full_name . ', ' .
                                trans('attendance.date') . ': ' . $date . ', ' .
                                trans('attendance.attendance_type') . ': ' . $option_type->title . ', ' .
                                trans('attendance.hour') . ': ' . $hour;

                            $smsMessage = new SmsMessage();
                            $smsMessage->text = $sms_text;
                            $smsMessage->number = $item->mobile;
                            $smsMessage->user_id = $item->id;
                            $smsMessage->user_id_sender = $this->user->id;
                            $smsMessage->save();

                            SMS::send($request->text, [], function ($sms) use ($item) {
                                $sms->to($item->mobile);
                            });
                        }
                    }
                }
            }
        }
    }

    public function attendanceForDate(AttendanceGetRequest $request)
    {
        $students = new Collection([]);
        $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
            ->each(function ($student) use ($students) {
                $students->push($student->id);
            });
        $attendances = $this->attendanceRepository->getAllForStudentsAndSchoolYear($students, session('current_school_year'))
            ->with('student', 'student.user')
            ->orderBy('hour')
            ->get()
            ->filter(function ($attendance) use ($request) {
                return (Carbon::createFromFormat(Settings::get('date_format'), $attendance->date) ==
                    Carbon::createFromFormat(Settings::get('date_format'), $request->date) &&
                    isset($attendance->student->user->full_name));
            })
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'name' => $attendance->student->user->full_name,
                    'hour' => $attendance->hour,
                    'option' => isset($attendance->option) ? $attendance->option->title : "",
                ];
            })->toArray();
        return json_encode($attendances);
    }

    public function deleteattendance(DeleteRequest $request)
    {
        $attendance = Attendance::find($request['id']);
        $attendance->delete();
    }

}
