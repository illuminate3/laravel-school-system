<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Http\Requests\Secure\BehaviorRequest;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\User;
use App\Repositories\BehaviorRepository;
use App\Repositories\StudentRepository;
use Datatables;
use Session;

class TeacherStudentController extends SecureController
{
    /**
     * @var BehaviorRepository
     */
    private $behaviorRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * TeacherStudentController constructor.
     * @param BehaviorRepository $behaviorRepository
     * @param StudentRepository $studentRepository
     */
    public function __construct(BehaviorRepository $behaviorRepository,
                                StudentRepository $studentRepository)
    {
        parent::__construct();
        $this->behaviorRepository = $behaviorRepository;
        $this->studentRepository = $studentRepository;

        view()->share('type', 'teacherstudent');
    }

    public function index()
    {
        $title = trans('teacherstudent.students');
        return view('teacherstudent.index', compact('title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Student $student)
    {
        $title = trans('teacherstudent.details');

        return view('teacherstudent.show', compact('student', 'title'));
    }

    public function behavior(Student $student)
    {
        $user = User::find($student->user_id);
        $title = trans('teacherstudent.behavior_title') . $user->first_name . ' ' . $user->last_name;
        $behaviors = $this->behaviorRepository->getAll()->get()->pluck('title', 'id')->toArray();
        return view('teacherstudent.behavior', compact('student', 'title', 'behaviors'));
    }

    public function change_behavior(BehaviorRequest $request, Student $student)
    {
        $student->behavior()->attach($request['behavior_id']);

        return redirect('/teacherstudent');
    }


    public function data()
    {
        $current_student_group = StudentGroup::find(session('current_student_group'));

        $section_teacher = isset($current_student_group->section->section_teacher_id) ? $current_student_group->section->section_teacher_id : "";
        $is_head_teacher = (!is_null($section_teacher) && $section_teacher == $this->user->id) ? 1 : 0;

        $studentsGroup = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->full_name,
                    'order' => isset($student->order) ? $student->order : " ",
                ];
            });
        if ($is_head_teacher > 0) {
            return Datatables::of($studentsGroup)
                ->add_column('actions', '<a href="{{ url(\'/teacherstudent/\' . $id . \'/behavior\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-edit"></i>  {{ trans("teacherstudent.behavior") }}</a>
                                     <a href="{{ url(\'/teacherstudent/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                ->remove_column('id')
                ->make();
        } else {
            return Datatables::of($studentsGroup)
                ->add_column('actions', '<a href="{{ url(\'/teacherstudent/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                ->remove_column('id')
                ->make();
        }
    }
}
