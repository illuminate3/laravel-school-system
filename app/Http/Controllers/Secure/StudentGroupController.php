<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\TimetableRequest;
use App\Models\Direction;
use App\Models\Section;
use App\Models\StudentGroup;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\Timetable;
use App\Repositories\SchoolDirectionRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherSubjectRepository;
use App\Repositories\TimetableRepository;
use App\Repositories\TeacherSchoolRepository;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;
use Sentinel;
use DB;
use App\Http\Requests\Secure\StudentGroupRequest;
use App\Http\Controllers\Traits\TimeTableTrait;

class StudentGroupController extends SecureController
{
    use TimeTableTrait;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var TeacherSchoolRepository
     */
    private $teacherSchoolRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var TimetableRepository
     */
    private $timetableRepository;
    /**
     * @var SchoolDirectionRepository
     */
    private $schoolDirectionRepository;

    /**
     * StudentGroupController constructor.
     * @param StudentRepository $studentRepository
     * @param SubjectRepository $subjectRepository
     * @param TeacherSchoolRepository $teacherSchoolRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param TimetableRepository $timetableRepository
     * @param SchoolDirectionRepository $schoolDirectionRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                SubjectRepository $subjectRepository,
                                TeacherSchoolRepository $teacherSchoolRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                TimetableRepository $timetableRepository,
                                SchoolDirectionRepository $schoolDirectionRepository)
    {
        parent::__construct();

        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->timetableRepository = $timetableRepository;
        $this->schoolDirectionRepository = $schoolDirectionRepository;

        $this->middleware('authorized:student_group.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:student_group.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:student_group.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:student_group.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'studentgroup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Section $section)
    {
        $title = trans('studentgroup.new');
        $directions = ['' => trans('studentgroup.select_direction')] +
            $this->schoolDirectionRepository->getAllForSchool(session('current_school'))
                ->with('direction')->get()
                ->pluck('direction.title', 'direction.id')->toArray();
        return view('layouts.create', compact('title', 'directions', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StudentGroupRequest $request)
    {
        $studentGroup = new StudentGroup($request->all());
        $studentGroup->save();
        return redirect('/section/' . $request->section_id . '/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.details');
        $action = 'show';
        return view('layouts.show', compact('studentGroup', 'title', 'action', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.edit');
        $directions = ['' => trans('studentgroup.select_direction')] +
            $this->schoolDirectionRepository->getAllForSchool(session('current_school'))
                ->with('direction')->get()
                ->pluck('direction.title', 'direction.id')->toArray();
        $class = array();
        $duration = isset($studentGroup->direction->duration) ? $studentGroup->direction->duration : 1;
        for ($i = 1; $i <= $duration; $i++) {
            $class[$i] = $i;
        }
        return view('layouts.edit', compact('title', 'studentGroup', 'section', 'directions', 'class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(StudentGroupRequest $request, StudentGroup $studentGroup)
    {
        $studentGroup->update($request->all());
        return redirect('/section/' . $request->section_id . '/groups');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.delete');
        return view('/studentgroup/delete', compact('studentGroup', 'title', 'section'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Section $section, StudentGroup $studentGroup)
    {
        $studentGroup->delete();
        return redirect('/section/' . $studentGroup->section_id . '/groups');
    }

    public function students(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.students');
        $students = $this->studentRepository
            ->getAllForSchoolYearAndSection(session('current_school_year'), $studentGroup->section_id)
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name,
                ];
            })->pluck('name', 'id')->toArray();

        return view('studentgroup.students', compact('studentGroup', 'title', 'section', 'students'));
    }

    public function addstudents(Section $section, StudentGroup $studentGroup, Request $request)
    {
        if (isset($request['students_select']) && $request['students_select'] != null) {
            $studentGroup->students()->sync($request['students_select']);
        }
        return redirect('/section/' . $section->id . '/groups');
    }

    public function subjects(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.subjects');
        $subjects = $this->subjectRepository
            ->getAllForDirectionAndClass($studentGroup->direction_id, $studentGroup->class)
            ->orderBy('order')
            ->get();

        $teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school'))
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->full_name,
                ];
            })->pluck('name', 'id')->toArray();

        $teacher_subject = array();
        foreach ($subjects as $item) {
            $teacher_subject[$item->id] =
                $this->teacherSubjectRepository->getAllForSubjectAndGroup($item->id, $studentGroup->id)
                    ->get()
                    ->pluck('teacher_id')->toArray();
        }

        return view('studentgroup.subjects', compact('studentGroup', 'title', 'subjects', 'section', 'teachers', 'teacher_subject'));
    }

    public function addeditsubject(Subject $subject, StudentGroup $studentGroup, Request $request)
    {
        $this->teacherSubjectRepository->getAllForSubjectAndGroup($subject->id, $studentGroup->id)
            ->delete();

        if (!empty($request['teachers_select'])) {
            foreach ($request['teachers_select'] as $teacher) {
                $teacherSubject = new TeacherSubject;
                $teacherSubject->subject_id = $subject->id;
                $teacherSubject->school_year_id = session('current_school_year');
                $teacherSubject->school_id = session('current_school');
                $teacherSubject->student_group_id = $studentGroup->id;
                $teacherSubject->teacher_id = $teacher;
                $teacherSubject->save();
            }
        }
    }

    public function timetable(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.timetable');
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroup(session('current_school_year'), $studentGroup->id)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                    'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);
        return view('studentgroup.timetable', compact('studentGroup', 'title', 'action', 'section', 'subject_list', 'timetable'));
    }

    public function addtimetable(Section $section, StudentGroup $studentGroup, TimetableRequest $request)
    {
        $timetable = new Timetable($request->all());
        $timetable->save();

        return $timetable->id;
    }

    public function deletetimetable(Section $section, StudentGroup $studentGroup, DeleteRequest $request)
    {
        $timetable = Timetable::find($request['id']);
        $timetable->delete();
    }

    public function getDuration(Request $request)
    {
        $direction = Direction::find($request['direction']);
        return isset($direction->duration) ? $direction->duration : 1;
    }


    public function print_timetable(Section $section, StudentGroup $studentGroup)
    {
        $title = trans('studentgroup.timetable');
        $subject_list = $this->teacherSubjectRepository
            ->getAllForSchoolYearAndGroup(session('current_school_year'), $studentGroup->id)
            ->with('teacher', 'subject')
            ->get()
            ->filter(function ($teacherSubject) {
                return (isset($teacherSubject->subject) && isset($teacherSubject->teacher));
            })
            ->map(function ($teacherSubject) {
                return [
                    'id' => $teacherSubject->id,
                    'title' => isset($teacherSubject->subject) ? $teacherSubject->subject->title : "",
                    'name' => isset($teacherSubject->teacher) ? $teacherSubject->teacher->full_name : "",
                ];
            });
        $timetable = $this->timetableRepository
            ->getAllForTeacherSubject($subject_list);

        $data = '<h1>' . $title . '</h1><table style="border: double">
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
