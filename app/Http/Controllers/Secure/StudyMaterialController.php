<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\StudyMaterialRequest;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Repositories\StudyMaterialRepository;
use App\Repositories\TeacherSubjectRepository;
use Datatables;
use Session;

class StudyMaterialController extends SecureController
{
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var StudyMaterialRepository
     */
    private $studyMaterialRepository;

    /**
     * DairyController constructor.
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param StudyMaterialRepository $studyMaterialRepository
     */
    public function __construct(TeacherSubjectRepository $teacherSubjectRepository,
                                StudyMaterialRepository $studyMaterialRepository)
    {
        parent::__construct();

        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->studyMaterialRepository = $studyMaterialRepository;

        view()->share('type', 'study_material');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('study_material.study_material');
        return view('study_material.index', compact('title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Subject $subject
     * @return Response
     */
    public function subject(Subject $subject)
    {
        $title = trans('study_material.study_material');
        return view('study_material.index', compact('title', 'subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('study_material.new');
        $subjects = $this->generateParams();
        return view('layouts.create', compact('title', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudyMaterialRequest $request
     * @return Response
     */
    public function store(StudyMaterialRequest $request)
    {
        $studyMaterial = new StudyMaterial($request->except('file_file'));
        if ($request->hasFile('file_file') != "") {
            $file = $request->file('file_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/study_material/';
            $file->move($destinationPath, $picture);
            $studyMaterial->file = $picture;
        }
        $studyMaterial->user_id = $this->user->id;
        $studyMaterial->student_group_id = session('current_student_group');
        $studyMaterial->save();

        return redirect('/study_material');
    }

    /**
     * Display the specified resource.
     *
     * @param StudyMaterial $studyMaterial
     * @return Response
     * @internal param int $id
     */
    public function show(StudyMaterial $studyMaterial)
    {
        $title = trans('study_material.details');
        $action = 'show';
        return view('layouts.show', compact('studyMaterial', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(StudyMaterial $studyMaterial)
    {
        $title = trans('study_material.edit');
        $subjects = $this->generateParams();
        return view('layouts.edit', compact('title', 'studyMaterial', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(StudyMaterialRequest $request, StudyMaterial $studyMaterial)
    {
        if ($request->hasFile('file_file') != "") {
            $file = $request->file('file_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/study_material/';
            $file->move($destinationPath, $picture);
            $studyMaterial->file = $picture;
        }
        $studyMaterial->update($request->except('file_file'));
        return redirect('/study_material');
    }

    /**
     * @param $website
     * @return Response
     */
    public function delete(StudyMaterial $studyMaterial)
    {
        $title = trans('study_material.delete');
        return view('/study_material/delete', compact('studyMaterial', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(StudyMaterial $studyMaterial)
    {
        $studyMaterial->delete();
        return redirect('/study_material');
    }

    public function data($subject_id = 0)
    {
        if ($this->user->inRole('teacher')) {
            $studyMaterials = $this->studyMaterialRepository
                ->getAllForUserAndGroup($this->user->id, session('current_student_group'))
                ->with('subject', 'student_group')
                ->get();
        } else if ($this->user->inRole('student')) {
            $studyMaterials = $this->studyMaterialRepository->getAllForStudent($this->user->id)
                ->with('subject', 'student_group')
                ->get();
        } else if ($this->user->inRole('parent')) {
            $user = session('current_student_user_id');

            $studyMaterials = $this->studyMaterialRepository->getAllForStudent($user)
                ->with('subject', 'student_group')
                ->get();
        } else {
            $studyMaterials = array();
        }

        if ($subject_id > 0) {
            $studyMaterials = $studyMaterials->filter(function ($item) use ($subject_id) {
                return $item->subject_id == $subject_id;
            });
        }
        $studyMaterials = $studyMaterials->map(function ($studyMaterial) {
            return [
                'id' => $studyMaterial->id,
                'title' => $studyMaterial->title,
                'subject' => isset($studyMaterial->subject) ? $studyMaterial->subject->title : "",
                'student_group' => isset($studyMaterial->student_group) ? $studyMaterial->student_group->title : "",
                'date_off' => $studyMaterial->date_off
            ];
        });
        if ($this->user->inRole('teacher')) {
            return Datatables::of($studyMaterials)
                ->add_column('actions', '<a href="{{ url(\'/study_material/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/study_material/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/study_material/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
                ->remove_column('id')
                ->make();
        } else {
            return Datatables::of($studyMaterials->toBase()->unique())
                ->add_column('actions', '<a href="{{ url(\'/study_material/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
                ->remove_column('id')
                ->make();
        }
    }

    /**
     * @return mixed
     */
    private
    function generateParams()
    {
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
        return $subjects;
    }

}
