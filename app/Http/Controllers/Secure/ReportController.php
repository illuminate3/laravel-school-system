<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\ReportRequest;
use App\Models\Exam;
use App\Models\OnlineExam;
use App\Models\Student;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use App\Repositories\BehaviorRepository;
use App\Repositories\BookRepository;
use App\Repositories\BookUserRepository;
use App\Repositories\ExamRepository;
use App\Repositories\MarkRepository;
use App\Repositories\NoticeRepository;
use App\Repositories\OnlineExamRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentFinalMarkRepository;
use App\Repositories\StudentGroupRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Session;

class ReportController extends SecureController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var ExamRepository
     */
    private $examRepository;
    /**
     * @var StudentGroupRepository
     */
    private $studentGroupRepository;
    /**
     * @var AttendanceRepository
     */
    private $attendanceRepository;
    /**
     * @var MarkRepository
     */
    private $markRepository;
    /**
     * @var BehaviorRepository
     */
    private $behaviorRepository;
    /**
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * @var BookUserRepository
     */
    private $bookUserRepository;
    /**
     * @var NoticeRepository
     */
    private $noticeRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var StudentFinalMarkRepository
     */
    private $studentFinalMarkRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;
    /**
     * @var OnlineExamRepository
     */
    private $onlineExamRepository;

    /**
     * ReportController constructor.
     * @param StudentRepository $studentRepository
     * @param ExamRepository $examRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @param AttendanceRepository $attendanceRepository
     * @param MarkRepository $markRepository
     * @param BehaviorRepository $behaviorRepository
     * @param BookRepository $bookRepository
     * @param BookUserRepository $bookUserRepository
     * @param NoticeRepository $noticeRepository
     * @param SemesterRepository $semesterRepository
     * @param OptionRepository $optionRepository
     * @param StudentFinalMarkRepository $studentFinalMarkRepository
     * @param SubjectRepository $subjectRepository
     * @param SchoolRepository $schoolRepository
     * @param OnlineExamRepository $onlineExamRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                ExamRepository $examRepository,
                                StudentGroupRepository $studentGroupRepository,
                                AttendanceRepository $attendanceRepository,
                                MarkRepository $markRepository,
                                BehaviorRepository $behaviorRepository,
                                BookRepository $bookRepository,
                                BookUserRepository $bookUserRepository,
                                NoticeRepository $noticeRepository,
                                SemesterRepository $semesterRepository,
                                OptionRepository $optionRepository,
                                StudentFinalMarkRepository $studentFinalMarkRepository,
                                SubjectRepository $subjectRepository,
                                SchoolRepository $schoolRepository,
                                OnlineExamRepository $onlineExamRepository)
    {
        parent::__construct();

        $this->studentRepository = $studentRepository;
        $this->examRepository = $examRepository;
        $this->studentGroupRepository = $studentGroupRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->markRepository = $markRepository;
        $this->behaviorRepository = $behaviorRepository;
        $this->bookRepository = $bookRepository;
        $this->bookUserRepository = $bookUserRepository;
        $this->noticeRepository = $noticeRepository;
        $this->semesterRepository = $semesterRepository;
        $this->optionRepository = $optionRepository;
        $this->studentFinalMarkRepository = $studentFinalMarkRepository;
        $this->subjectRepository = $subjectRepository;
        $this->schoolRepository = $schoolRepository;
        $this->onlineExamRepository = $onlineExamRepository;

        view()->share('type', 'report');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('report.report');
        $exams = array();
        if ($this->user->inRole('teacher')) {
            $students = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
                ->map(function ($student) {
                    return [
                        'id' => $student->user_id,
                        'name' => $student->user->full_name
                    ];
                })
                ->pluck('name', 'id')->toArray();

            $exams = $this->examRepository->getAllForGroup(session('current_student_group'))
                ->with('subject')
                ->get()
                ->filter(function ($exam) {
                    return isset($exam->subject);
                })
                ->map(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'name' => $exam->title . ' ' . $exam->subject->title,
                    ];
                })->pluck('name', 'id')->toArray();
        }
        if ($this->user->inRole('admin')) {
            $students = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
                ->get()
                ->map(function ($student) {
                    return [
                        'id' => $student->user_id,
                        'name' => $student->user->full_name
                    ];
                })
                ->pluck('name', 'id')->toArray();

            $exams = $this->examRepository->getAll()
                ->with('subject', 'student_group')
                ->get()
                ->filter(function ($exam) {
                    return (isset($exam->subject) &&
                        isset($exam->student_group) &&
                        $exam->student_group->school_year_id == session('current_school_id'));
                })
                ->map(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'name' => $exam->title . ' ' . $exam->subject->title,
                    ];
                })->pluck('name', 'id')->toArray();
        }
        $start_date = $end_date = date('d.m.Y.');
        $report_type = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'report_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->value,
                ];
            })->pluck('title', 'value')->toArray();
        return view('report.index', compact('title', 'students', 'start_date', 'end_date', 'exams', 'report_type'));
    }


    public function student(User $user)
    {
        $title = trans('report.report');
        $students = array();

        $students[$user->id] = $user->full_name;
        $student = Student::where('user_id', $user->id)
            ->where('school_year_id', session('current_school_year'))
            ->first();

        $student_groups = new Collection([]);
        $stGroups = array();
        $this->studentGroupRepository->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->with('students')
            ->get()
            ->each(function ($group) use ($student, $student_groups) {
                foreach ($group->students as $student_item) {
                    if ($student_item->id == $student->id) {
                        $student_groups->push($group);
                    }
                }
            });
        foreach ($student_groups as $group) {
            $stGroups[] = $group->id;
        }

        $exams = $this->examRepository->getAll()
            ->with('subject', 'student_group')
            ->whereIn('student_group_id', $stGroups)
            ->get()
            ->filter(function ($exam) use ($student) {
                return isset($exam->subject);
            })
            ->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'name' => $exam->title . ' - ' . $exam->subject->title,
                ];
            })->pluck('name', 'id')->toArray();

        $start_date = $end_date = date('d.m.Y.');
        $report_type = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'report_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->value,
                ];
            })->pluck('title', 'value')->toArray();
        return view('report.index', compact('title', 'students', 'start_date', 'end_date', 'exams', 'report_type'));
    }

    public function create(ReportRequest $request)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        switch ($request->report_type) {
            case 'list_attendances':
                $data = $this->getListOfAttendances($request);
                break;
            case 'list_marks':
                $data = $this->getListOfMarks($request);
                break;
            case 'list_exam_marks':
                $data = $this->getListOfExamMarks($request);
                break;
            case 'list_behaviors':
                $data = $this->getListOfBehaviors($request);
                break;
        }
        $school = $this->studentRepository->getSchoolForStudent($request->student_id, session('current_school_year'))
            ->with('school')->get()
            ->map(function ($item) {
                return [
                    "title" => $item->school->title,
                    "address" => $item->school->address,
                    "email" => $item->school->email,
                    "phone" => $item->school->phone,
                ];
            });
        $pdf->loadView('report.' . $request->report_type, compact('data', 'school'));
        return $pdf->stream();
    }

    private function getListOfAttendances($request)
    {
        $attendaces = new Collection([]);
        $this->attendanceRepository->getAllForSchoolYearAndBetweenDate(session('current_school_year'), $request->start_date, $request->end_date)
            ->each(function ($attendaceItem) use ($request, $attendaces) {
                foreach ($request->student_id as $student_user_id) {
                    if ($student_user_id == $attendaceItem->student->user_id)
                        $attendaces->push($attendaceItem);
                }
            });
        $attendaces = $attendaces->map(function ($attendace) {
            return [
                'date' => Carbon::createFromFormat(Settings::get('date_format'), $attendace->date)->toDateString(),
                'attendance_type' => isset($attendace->option) ? $attendace->option->title : "",
                'hour' => $attendace->hour,
                'name' => isset($attendace->student->user->full_name) ? $attendace->student->user->full_name : "",
            ];
        });
        $result = ' <h1>' . trans('report.list_attendances') . '</h1>
                    ' . $request['start_date'] . ' - ' . $request['end_date'] . '<br>
                    <table>
                        <thead>
                            <tr>
                            <th>' . trans('report.student') . '</th>
                            <th>' . trans('report.date') . '</th>
                            <th>' . trans('report.hour') . '</th>
                            <th>' . trans('report.attendance_type') . '</th>
                            </tr>
                        </thead><tbody>';
        foreach ($attendaces as $item) {
            $result .= '<tr>
                                        <td>' . $item['name'] . '</td>
                                        <td>' . $item['date'] . '</td>
                                        <td>' . $item['hour'] . '</td>
                                        <td>' . $item['attendance_type'] . '</td>
                                     </tr>';
        }
        $result .= '</tbody></table>';
        return $result;
    }

    private function getListOfMarks($request)
    {
        $marks = new Collection([]);
        $this->markRepository->getAllForSchoolYearAndBetweenDate(session('current_school_year'), $request->start_date, $request->end_date)
            ->each(function ($markItem) use ($request, $marks) {
                foreach ($request->student_id as $student_user_id) {
                    if ($student_user_id == $markItem->student->user_id)
                        $marks->push($markItem);
                }
            });
        $marks = $marks->map(function ($mark) {
            return [
                'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                'mark_value' => isset($mark->mark_value) ? $mark->mark_value->title : '',
                'subject' => isset($mark->subject) ? $mark->subject->title : '',
                'name' => isset($mark->student->user->full_name) ? $mark->student->user->full_name : "",
            ];
        });
        $result = '<h1>' . trans('report.list_marks') . '</h1>
                    ' . $request['start_date'] . ' - ' . $request['end_date'] . '<br>
                    <table>
                        <thead>
                            <tr>
                            <th>' . trans('report.student') . '</th>
                            <th>' . trans('report.date') . '</th>
                            <th>' . trans('report.mark_value') . '</th>
                            <th>' . trans('report.mark_type') . '</th>
                            <th>' . trans('report.subject') . '</th>
                            </tr>
                        </thead><tbody>';
        foreach ($marks as $item) {
            $result .= '<tr>
                            <td>' . $item['name'] . '</td>
                            <td>' . $item['date'] . '</td>
                            <td>' . $item['mark_value'] . '</td>
                            <td>' . $item['mark_type'] . '</td>
                            <td>' . $item['subject'] . '</td>
                         </tr>';
        }
        $result .= '</tbody></table>';
        return $result;
    }

    private function getListOfExamMarks($request)
    {
        $marks = new Collection([]);
        $this->markRepository->getAllForSchoolYearAndExam(session('current_school_year'), $request->exam_id)
            ->each(function ($markItem) use ($request, $marks) {
                foreach ($request->student_id as $student_user_id) {
                    if ($student_user_id == $markItem->student->user_id)
                        $marks->push($markItem);
                }
            });
        $marks = $marks->map(function ($mark) {
            return [
                'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                'mark_value' => isset($mark->mark_value) ? $mark->mark_value->title : '',
                'subject' => isset($mark->subject) ? $mark->subject->title : '',
                'name' => isset($mark->student->user->full_name) ? $mark->student->user->full_name : "",
            ];
        });
        $exam = Exam::find($request['exam_id'])->first();
        $result = '<h1>' . trans('report.list_marks_exam') . ' - ' . $exam->title . '</h1>
                    <table>
                        <thead>
                            <tr>
                            <th>' . trans('report.student') . '</th>
                            <th>' . trans('report.date') . '</th>
                            <th>' . trans('report.mark_value') . '</th>
                            <th>' . trans('report.mark_type') . '</th>
                            <th>' . trans('report.subject') . '</th>
                            </tr>
                        </thead><tbody>';
        foreach ($marks as $item) {
            $result .= '<tr>
                            <td>' . $item['name'] . '</td>
                            <td>' . $item['date'] . '</td>
                            <td>' . $item['mark_value'] . '</td>
                            <td>' . $item['mark_type'] . '</td>
                            <td>' . $item['subject'] . '</td>
                         </tr>';
        }
        $result .= '</tbody></table>';
        return $result;
    }

    private function getListOfBehaviors($request)
    {
        $behaviours = new Collection([]);
        $this->behaviorRepository->getAll()
            ->with('students', 'students.user')
            ->get()
            ->each(function ($behaviourItem) use ($request, $behaviours) {
                foreach ($request->student_id as $student_user_id) {
                    if (isset($behaviourItem->students)) {
                        foreach ($behaviourItem->students as $studentItem) {
                            if ($student_user_id == $studentItem->user_id &&
                                $studentItem->school_year_id == session('current_school_year')
                            ) {
                                $behaviours->push($behaviourItem);
                            }
                        }
                    }
                }
            });
        $behaviours = $behaviours
            ->map(function ($behaviour) {
                return [
                    'behaviour' => $behaviour->title,
                    'name' => isset($behaviour->students->first()->user->full_name) ?
                        $behaviour->students->first()->user->full_name : "",
                ];
            });

        $result = '<h1>' . trans('report.behaviours') . '</h1>
                    <table>
                        <thead>
                            <tr>
                            <th>' . trans('report.student') . '</th>
                            <th>' . trans('report.behaviour') . '</th>
                            </tr>
                        </thead><tbody>';
        foreach ($behaviours as $item) {
            $result .= '<tr>
                            <td>' . $item['name'] . '</td>
                            <td>' . $item['behaviour'] . '</td>
                         </tr>';
        }
        $result .= '</tbody></table>';
        return $result;
    }

    public function attendances(User $user)
    {
        $title = trans('report.attendances');
        $method = 'getAttendances';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'student_user', 'method'));
    }

    public function marks(User $user)
    {
        $title = trans('report.marks');
        $method = 'getMarks';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'student_user', 'method'));
    }

    public function notice(User $user)
    {
        $title = trans('report.notices');
        $method = 'getNotices';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'student_user', 'method'));
    }

    public function subjectbook(User $user)
    {
        $title = trans('report.subjectbook');
        $method = 'getSubjectBook';
        if ($this->user->inRole('parent')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'method', 'student_user'));
    }

    public function exams(User $user)
    {
        $title = trans('report.exams');
        $method = 'getSubjectExams';
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;
        return view('report.list', compact('title', 'method', 'student_user'));
    }

    public function onlineExams(User $user)
    {
        $title = trans('report.online_exams');
        if (!$this->user->inRole('student')) {
            $user = User::find(session('current_student_user_id'));
        }
        $student_user = $user;

        $onlineExamList = $this->onlineExamRepository->getAllForStudentUserId($user->id)
            ->map(function ($onlineExam) {
                return [
                    'id' => $onlineExam->id,
                    'title' => $onlineExam->title,
                    'date_start' => $onlineExam->date_start,
                    'date_end' => $onlineExam->date_end,
                    'subject' => isset($onlineExam->subject->title) ? $onlineExam->subject->title : "",
                ];
            });
        return view('report.online_exam', compact('title', 'onlineExamList', 'student_user'));
    }

    public function getStudentSubjects(User $user)
    {
        return $this->subjectRepository->getAllStudentsSubjectAndDirection()
            ->where('students.user_id', $user->id)
            ->where('students.school_year_id', session('current_school_year'))
            ->orderBy('subjects.class')
            ->orderBy('subjects.order')
            ->select('subjects.id', 'subjects.title')->pluck('subjects.title', 'subjects.id')->toArray();
    }

    public function semesters(User $user)
    {
        return $this->semesterRepository->getAll()
            ->with('students')
            ->orderBy('start')
            ->get()
            ->filter(function ($semester) use ($user) {
                return ($semester->students->user_id = $user->id);
            })
            ->map(function ($semester) {
                return [
                    'id' => $semester->id,
                    'title' => $semester->title,
                ];
            })->pluck('title', 'id')->toArray();
    }

    public function marksForSubject(User $user, Request $request)
    {
        $marks = $this->markRepository->getAllForSchoolYearSubjectUserAndSemester(session('current_school_year'), $request->subject_id, $user->id, $request->semester_id)
            ->map(function ($mark) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $mark->date)->toDateString(),
                    'mark_type' => isset($mark->mark_type) ? $mark->mark_type->title : '',
                    'mark_value' => isset($mark->mark_value) ? $mark->mark_value->title : '',
                ];
            })->toArray();

        $student = Student::where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))
            ->where('user_id', $user->id)->first();

        $final_marks = $this->studentFinalMarkRepository
            ->getAllForStudentSubjectSchoolYearSchool($student->id, $request->subject_id,
                session('current_school_year'), session('current_school'))
            ->with('mark_value')
            ->get()
            ->map(function ($final_mark) {
                return [
                    'date' => $final_mark->created_at->format(Settings::get('date_format')),
                    'mark_type' => trans('student_final_mark.final_mark'),
                    'mark_value' => isset($final_mark->mark_value) ? $final_mark->mark_value->title : '',
                ];
            })->toArray();
        return $marks + $final_marks;
    }

    public function attendancesForSubject(User $user, Request $request)
    {
        return $attendance = $this->attendanceRepository->getAllForSchoolYearSubjectuserAndSemester(session('current_school_year'), $request->subject_id, $user->id, $request->semester_id)
            ->map(function ($attendace) {
                return [
                    'date' => $attendace->date,
                    'attendance_type' => ($attendace->option) ? $attendace->option->title : "",
                    'hour' => $attendace->hour
                ];
            });
    }

    public function noticesForSubject(User $user, Request $request)
    {
        $notices = $this->noticeRepository->getAllForSchoolYearAndSchool(session('current_school_year'),
            session('current_school'))
            ->with('student_group', 'student_group.students')
            ->orderBy('date')
            ->get()
            ->filter(function ($notice) use ($request) {
                return ($notice->subject_id == $request->subject_id && isset($notice->student_group->students));
            })
            ->map(function ($notice) {
                return [
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $notice->date)->toDateString(),
                    'title' => $notice->title,
                    'description' => $notice->description
                ];
            })
            ->toBase()->unique();
        return $notices;
    }

    public function getSubjectBook(Request $request)
    {
        return $this->bookRepository->getAll()
            ->get()
            ->filter(function ($book) use ($request) {
                return ($book->subject_id == $request->subject_id);
            })
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'publisher' => $book->publisher,
                    'version' => $book->version,
                    'quantity' => $book->quantity,
                    'author' => $book->author,
                    'title' => $book->title,
                    'issued' => $this->bookUserRepository->getAll()
                        ->get()
                        ->filter(function ($item) use ($book) {
                            return ($item->book_id == $book->id &&
                                (!is_null($item->get)) && is_null($item->back));
                        })->count()
                ];
            });
    }

    public function examForSubject(User $user, Request $request)
    {
        $student_groups = new Collection([]);
        $stGroups = array();
        $this->studentGroupRepository->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->with('students', 'students.user')
            ->get()
            ->each(function ($group) use ($user, $student_groups) {
                foreach ($group->students as $student_item) {
                    if ($student_item->user->id == $user->id) {
                        $student_groups->push($group);
                    }
                }
            });
        foreach ($student_groups as $group) {
            $stGroups[] = $group->id;
        }

        return $this->examRepository->getAll()
            ->with('subject', 'student_group')
            ->whereIn('student_group_id', $stGroups)
            ->get()
            ->filter(function ($exam) use ($request) {
                return (isset($exam->subject) && $exam->subject_id == $request->subject_id);
            })
            ->map(function ($exam) {
                return [
                    'title' => $exam->title,
                    'subject' => $exam->subject->title,
                    'date' => Carbon::createFromFormat(Settings::get('date_format'), $exam->date)->toDateString(),
                    'description' => $exam->description,
                ];
            });
    }
}
