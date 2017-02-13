<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\TimetableRequest;
use App\Models\StudentGroup;
use App\Models\Timetable;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSubjectRepository;
use App\Repositories\TimetableRepository;
use Illuminate\Support\Collection;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\Http\Controllers\Traits\TimeTableTrait;

class TeacherGroupController extends SecureController
{
    use TimeTableTrait;
    /**
     * @var TimetableRepository
     */
    private $timetableRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * TeacherGroupController constructor.
     * @param TimetableRepository $timetableRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param StudentRepository $studentRepository
     */
    public function __construct(TimetableRepository $timetableRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                StudentRepository $studentRepository)
    {
        parent::__construct();

        $this->timetableRepository = $timetableRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->studentRepository = $studentRepository;

        view()->share('type', 'teachergroup');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(StudentGroup $studentGroup)
    {
        $title = trans('teachergroup.details');
        $action = 'show';
        return view('teachergroup.show', compact('studentGroup', 'title', 'action'));
    }

    public function index()
    {
        $title = trans('teachergroup.mygroups');
        return view('teachergroup.mygroup', compact('title'));
    }

    public function data()
    {
        $studentGroups = $this->teacherSubjectRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('student_group', 'student_group.direction')
            ->get()
            ->each(function ($teacherSubject) {
                if ($teacherSubject->teacher_id == $this->user->id && $teacherSubject->student_group->direction) {
                    return true;
                }
            })
            ->map(function ($studentGroup) {
                return [
                    'id' => $studentGroup->student_group->id,
                    'title' => $studentGroup->student_group->title,
                    'direction' => isset($studentGroup->student_group->direction->title) ? $studentGroup->student_group->direction->title : "",
                    "class" => $studentGroup->student_group->class,
                ];
            });
        return Datatables::of($studentGroups->toBase()->unique())
            ->add_column('actions', '<a href="{{ url(\'/teachergroup/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/teachergroup/\' . $id . \'/students\' ) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-users"></i> {{ trans("section.students") }}</a>
                                    <a href="{{ url(\'/teachergroup/\' . $id . \'/generate_csv\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-file-excel-o"></i>  {{ trans("section.generate_csv") }}</a>
                                     <a href="{{ url(\'/teachergroup/\' . $id . \'/grouptimetable\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-calendar"></i>  {{ trans("teachergroup.timetable") }}</a>')
            ->remove_column('id')
            ->make();
    }
    public function generateCsvStudentsGroup(StudentGroup $studentGroup){

        $students = $this->studentRepository->getAllForStudentGroup($studentGroup->id)
            ->map(function ($student) {
                return [
                    'Order No.' => $student->order,
                    'First name' => $student->user->first_name,
                    'Last name' => $student->user->last_name,
                ];
            })->toArray();
        Excel::create(trans('section.students'), function($excel) use ($students){
            $excel->sheet(trans('section.students'), function($sheet) use ($students) {
                $sheet->fromArray($students, null, 'A1', true);
            });
        })->export('csv');
    }

    public function students(StudentGroup $studentGroup)
    {
        $title = trans('teachergroup.students');
        $students_added = $this->studentRepository->getAllForStudentGroup($studentGroup->id)->pluck('id')->all();
        $students = $this->studentRepository->getAllForSchoolYear(session('current_school_year'))
            ->get()
            ->filter(function($student){
                return isset($student->user);
            })
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name
                ];
            })
            ->pluck('name', 'id')->toArray();
        return view('teachergroup.students', compact('studentGroup', 'title', 'section', 'students', 'students_added'));
    }

    public function addstudents(StudentGroup $studentGroup, Request $request)
    {
        $studentGroup->students()->sync($request['students_select']);
        return redirect('/teachergroup');
    }

    public function grouptimetable(StudentGroup $studentGroup)
    {
        $title = trans('teachergroup.timetable');

        $school_year_id = session('current_school_year');

        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroup($school_year_id, $studentGroup->id)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) &&
                    $teacherSubject->teacher_id == $this->user->id &&
                    isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => $teacherSubject->subject->title,
                    'name' => $teacherSubject->teacher->full_name,
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);

        return view('teachergroup.timetable', compact('studentGroup', 'title', 'section', 'subject_list', 'timetable'));
    }

    public function addtimetable(TimetableRequest $request)
    {
        $timetable = new Timetable($request->all());
        $timetable->save();

        return $timetable->id;
    }

    public function deletetimetable(DeleteRequest $request)
    {
        $timetable = Timetable::find($request['id']);
        if (!is_null($timetable)) {
            $timetable->delete();
        }
    }

    public function timetable()
    {
        $title = trans('teachergroup.timetable');

        $school_year_id = session('current_school_year');

        $studentgroups = new Collection([]);
        $studentGroupsList = $this->teacherSubjectRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('student_group', 'student_group.direction')
            ->get()
            ->each(function ($teacherSubject) {
                if ($teacherSubject->teacher_id == $this->user->id && $teacherSubject->student_group->direction) {
                    return true;
                }
            })
            ->map(function ($studentGroup) {
                return [
                    'id' => $studentGroup->student_group->id,
                    'title' => $studentGroup->student_group->title,
                    'direction' => isset($studentGroup->student_group->direction->title) ? $studentGroup->student_group->direction->title : "",
                    "class" => $studentGroup->student_group->class,
                ];
            })->toBase()->unique();
        foreach ($studentGroupsList as $items) {
            $studentgroups->push($items['id']);
        }
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroups($school_year_id, $studentgroups)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) &&
                    $teacherSubject->teacher_id == $this->user->id &&
                    isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => $teacherSubject->subject->title,
                    'name' => $teacherSubject->teacher->full_name,
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);

        return view('teachergroup.timetable', compact('title', 'action', 'subject_list', 'timetable'));
    }

    public function print_timetable()
    {
        $title = trans('teachergroup.timetable');

        $school_year_id = session('current_school_year');

        $studentgroups = new Collection([]);
        $studentGroupsList = $this->teacherSubjectRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('student_group', 'student_group.direction')
            ->get()
            ->each(function ($teacherSubject) {
                if ($teacherSubject->teacher_id == $this->user->id && $teacherSubject->student_group->direction) {
                    return true;
                }
            })
            ->map(function ($studentGroup) {
                return [
                    'id' => $studentGroup->student_group->id,
                    'title' => $studentGroup->student_group->title,
                    'direction' => isset($studentGroup->student_group->direction->title) ? $studentGroup->student_group->direction->title : "",
                    "class" => $studentGroup->student_group->class,
                ];
            })->toBase()->unique();
        foreach ($studentGroupsList as $items) {
            $studentgroups->push($items['id']);
        }
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroups($school_year_id, $studentgroups)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) &&
                    $teacherSubject->teacher_id == $this->user->id &&
                    isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => $teacherSubject->subject->title,
                    'name' => $teacherSubject->teacher->full_name,
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);

        $data = '<h1>' . $title . '</h1>
				<table style="border: double">
					<tbody>
					<tr>
						<th>#</th>
						<th width="14%">' . trans('teachergroup.monday') . '</th>
						<th width="14%">' . trans('teachergroup.tuesday') . '</th>
						<th width="14%">' . trans('teachergroup.wednesday') . '</th>
						<th width="14%">' . trans('teachergroup.thursday') . '</th>
						<th width="14%">' . trans('teachergroup.friday') . '</th>
                        <th width="14%">' . trans('teachergroup.saturday') . '</th>
                        <th width="14%">' . trans('teachergroup.sunday') . '</th>
					</tr>';
        for ($i = 1; $i < 8; $i++) {
            $data .= '<tr>
            <td>' . $i . '</td>';
            for ($j = 1; $j < 8; $j++) {
                $data .= '<td>';
                foreach ($timetable as $item) {
                    if ($item['week_day'] == $j && $item['hour'] == $i) {
                        $data .= '<div>
                            <span>' . $item['title'] . '</span>
                            <br>
                            <span>' . $item['name'] . '</span></div>';
                    }
                }
                $data .= '</td>';
            }
            $data .= '</tr>';
        }
        $data .= '</tbody>
				</table>';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('report.timetable', compact('data'));
        return $pdf->stream();
    }

}
