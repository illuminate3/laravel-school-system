<?php

namespace App\Http\Controllers\Secure;

use App\Events\Mark\MarkCreated;
use App\Http\Requests\Secure\AddMarkRequest;
use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\ExamGetRequest;
use App\Http\Requests\Secure\MarkGetRequest;
use App\Http\Requests\Secure\MarkSystemGetRequest;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\MarkValue;
use App\Models\ParentStudent;
use App\Models\Semester;
use App\Models\SmsMessage;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Repositories\ExamRepository;
use App\Repositories\MarkSystemRepository;
use App\Repositories\MarkTypeRepository;
use App\Repositories\MarkValueRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use App\Repositories\MarkRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSubjectRepository;
use Datatables;
use Session;
use SMS;

class MarkController extends SecureController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var MarkRepository
     */
    private $markRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var ExamRepository
     */
    private $examRepository;
    /**
     * @var MarkValueRepository
     */
    private $markValueRepository;
    /**
     * @var MarkTypeRepository
     */
    private $markTypeRepository;
    /**
     * @var MarkSystemRepository
     */
    private $markSystemRepository;

    /**
     * MarkController constructor.
     * @param StudentRepository $studentRepository
     * @param MarkRepository $markRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param ExamRepository $examRepository
     * @param MarkValueRepository $markValueRepository
     * @param MarkTypeRepository $markTypeRepository
     * @param MarkSystemRepository $markSystemRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                MarkRepository $markRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                ExamRepository $examRepository,
                                MarkValueRepository $markValueRepository,
                                MarkTypeRepository $markTypeRepository,
                                MarkSystemRepository $markSystemRepository)
    {
        parent::__construct();

        $this->studentRepository = $studentRepository;
        $this->markRepository = $markRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->examRepository = $examRepository;
        $this->markValueRepository = $markValueRepository;
        $this->markTypeRepository = $markTypeRepository;
        $this->markSystemRepository = $markSystemRepository;

        view()->share('type', 'mark');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('mark.marks');
        $students = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name,
                ];
            })->pluck('name', 'id')->toArray();
        $subjects = ['' => trans('mark.select_subject')] +
            $this->teacherSubjectRepository
                ->getAllForSchoolYearAndGroupAndTeacher(session('current_school_year'), session('current_student_group'), $this->user->id)
                ->with('subject')
                ->get()
                ->filter(function ($subject) {
                    return (isset($subject->subject->title));
                })
                ->map(function ($subject) {
                    return [
                        'id' => $subject->subject_id,
                        'title' => $subject->subject->title
                    ];
                })->pluck('title', 'id')->toArray();
        $marktype = $this->markTypeRepository->getAll()->get()->pluck('title', 'id')->toArray();
        return view('mark.index', compact('title', 'students', 'subjects', 'marktype'));
    }

    public function marksForSubjectAndDate(MarkGetRequest $request)
    {
        $marks = $this->markRepository->getAll()
            ->with('student', 'student.user', 'mark_type', 'mark_value', 'subject')
            ->get()
            ->filter(function ($marksItem) use ($request) {
                return ($marksItem->school_year_id == session('current_school_year') &&
                    $marksItem->subject_id == $request->subject_id &&
                    Carbon::createFromFormat(Settings::get('date_format'), $marksItem->date) == Carbon::createFromFormat(Settings::get('date_format'), $request->date));
            })
            ->map(function ($mark) {
                return [
                    'id' => $mark->id,
                    'name' => isset($mark->student->user->full_name) ? $mark->student->user->full_name : "",
                    'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                    'mark_value' => isset($mark->mark_value) ? $mark->mark_value->title : '',
                ];
            });

        return json_encode($marks);
    }

    public function examsForSubject(ExamGetRequest $request)
    {
        return $this->examRepository->getAllForGroupAndSubject(session('current_student_group'), $request['subject_id'])
            ->get()
            ->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                ];
            })->pluck('title', 'id')->toArray();
    }

    public function markValuesForSubject(MarkSystemGetRequest $request)
    {
        return $this->markValueRepository->getAllForSubject($request['subject_id'])
            ->get()
            ->map(function ($mark_value) {
                return [
                    'id' => $mark_value->id,
                    'title' => $mark_value->title,
                ];
            })->pluck('title', 'id')->toArray();
    }

    public function deleteMark(DeleteRequest $request)
    {
        $mark = Mark::find($request['id']);
        $mark->delete();
    }

    public function addmark(AddMarkRequest $request)
    {
        $date = date_format(date_create_from_format(Settings::get('date_format'), $request->date), 'd-m-Y');
        $semestar = Semester::where(function ($query) use ($date) {
            $query->where('start', '>=', $date)
                ->where('school_year_id', '=', session('current_school_year'));
        })->orWhere(function ($query) use ($date) {
            $query->where('end', '<=', $date)
                ->where('school_year_id', '=', session('current_school_year'));
        })->first();
        foreach ($request['students'] as $student_id) {
            $mark = new Mark($request->except('students', '_token'));
            $mark->teacher_id = $this->user->id;
            $mark->student_id = $student_id;
            $mark->school_year_id = session('current_school_year');
            $mark->semester_id = isset($semestar->id) ? $semestar->id : 1;
            $mark->save();

            //event(new MarkCreated($mark));

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
                    $subject = Subject::find($request->subject_id);
                    $mark_type = MarkType::find($request->mark_type_id);
                    $mark_value = MarkValue::find($request->mark_value_id);

                    $sms_text = trans('mark.student') . ": " . $student->full_name . ', ' .
                        trans('mark.date') . ': ' . $date . ', ' .
                        trans('mark.subject') . ': ' . $subject->title . ', ' .
                        trans('mark.mark_type') . ': ' . $mark_type->title . ', ' .
                        trans('mark.mark_value') . ': ' . $mark_value->title;

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
