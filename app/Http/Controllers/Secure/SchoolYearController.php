<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Http\Requests\Secure\CreateNewSections;
use App\Http\Requests\Secure\SchoolYearRequest;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Repositories\SchoolRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SectionRepository;
use App\Repositories\StudentRepository;
use Datatables;
use Session;
use DB;

class SchoolYearController extends SecureController
{
    /**
     * @var SchoolYearRepository
     */
    private $schoolYearRepository;
    /**
     * @var SectionRepository
     */
    private $sectionRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;

    /**
     * SchoolYearController constructor.
     * @param SchoolYearRepository $schoolYearRepository
     * @param SectionRepository $sectionRepository
     * @param StudentRepository $studentRepository
     * @param SchoolRepository $schoolRepository
     */
    public function __construct(SchoolYearRepository $schoolYearRepository,
                                SectionRepository $sectionRepository,
                                StudentRepository $studentRepository,
                                SchoolRepository $schoolRepository)
    {
        parent::__construct();

        $this->schoolYearRepository = $schoolYearRepository;
        $this->sectionRepository = $sectionRepository;
        $this->studentRepository = $studentRepository;
        $this->schoolRepository = $schoolRepository;

        view()->share('type', 'schoolyear');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('schoolyear.schoolyear');
        return view('schoolyear.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('schoolyear.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchoolYearRequest $request
     * @return Response
     */
    public function store(SchoolYearRequest $request)
    {
        $schoolYear = new SchoolYear($request->all());
        $schoolYear->save();

        return redirect('/schoolyear');
    }

    /**
     * Display the specified resource.
     *
     * @param  SchoolYear $schoolYear
     * @return Response
     */
    public function show(SchoolYear $schoolYear)
    {
        $title = trans('schoolyear.details');
        $action = 'show';
        return view('layouts.show', compact('schoolYear', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SchoolYear $schoolYear
     * @return Response
     */
    public function edit(SchoolYear $schoolYear)
    {
        $title = trans('schoolyear.edit');
        return view('layouts.edit', compact('title', 'schoolYear'));
    }

    /**
     * Update the specified resource in storage.
     * @param SchoolYearRequest $request
     * @param  SchoolYear $schoolYear
     * @return Response
     */
    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
        $schoolYear->update($request->all());
        return redirect('/schoolyear');
    }

    /**
     * @param SchoolYear $schoolYear
     * @return Response
     */
    public function delete(SchoolYear $schoolYear)
    {
        $title = trans('schoolyear.delete');
        return view('/schoolyear/delete', compact('schoolYear', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SchoolYear $schoolYear
     * @return Response
     */
    public function destroy(SchoolYear $schoolYear)
    {
        $schoolYear->delete();
        return redirect('/schoolyear');
    }

    public function data()
    {
        $schoolYears = $this->schoolYearRepository->getAll()
            ->get()
            ->map(function ($schoolYear) {
                return [
                    'id' => $schoolYear->id,
                    'title' => $schoolYear->title,
                ];
            });

        return Datatables::of($schoolYears)
            ->add_column('actions', '<a href="{{ url(\'/schoolyear/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/schoolyear/\' . $id . \'/copy_data\' ) }}" class="btn btn-default btn-sm" >
                                            <i class="fa fa-files-o"></i>  {{ trans("schoolyear.copy_sections_students") }}</a>
                                    <a href="{{ url(\'/schoolyear/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/schoolyear/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }

    public function copyData(SchoolYear $schoolYear)
    {
        $title = trans('schoolyear.copy_sections_students_to') . $schoolYear->title;
        $school_year_list = ['' => trans('schoolyear.schoolyear_select')] +
            $this->schoolYearRepository->getAll()->where('id', '<>', $schoolYear->id)->pluck('title', 'id')->toArray();

        $school_list = ['' => trans('schoolyear.select_school')] +
                    $this->schoolRepository->getAll()->pluck('title', 'id')->toArray();
        return view('schoolyear/copy', compact('schoolYear', 'title', 'school_year_list','school_list'));
    }

    public function getSections(SchoolYear $schoolYear,School $school)
    {
        return $this->sectionRepository->getAllForSchoolYearSchool($schoolYear->id, $school->id)->get()
            ->pluck('title', 'id')->toArray();
    }
    public function getStudents(Section $section)
    {
        return $this->studentRepository->getAllForSection($section->id)
            ->map(function ($student) {
                return [
                    'id' => $student->user_id,
                    'title' => $student->user->full_name,
                ];
            })
            ->pluck('title', 'id')->toArray();
    }

    public function postData(SchoolYear $schoolYear,CreateNewSections $request)
    {
        DB::beginTransaction();
        $section = Section::find($request->get('section_id'));
        if (isset($section)) {
            $section_new = new Section();
            $section_new->school_year_id = $schoolYear->id;
            $section_new->section_teacher_id = $section->section_teacher_id;
            $section_new->school_id = $request->get('select_school_id');
            $section_new->title = $request->get('section_name');
            $section_new->save();

            if (!empty($request->get('students_list'))) {
                foreach ($request->get('students_list') as $student_user_id) {
                    $old_student = Student::where('user_id', $student_user_id)
                        ->where('school_year_id', $request->get('select_school_year_id'))
                        ->where('school_id', $request->get('select_school_id'))->first();
                    $student_new = Student::create(['school_year_id'=>$schoolYear->id,
                                                    'user_id'=>$student_user_id,
                                                    'section_id'=>$section_new->id,
                                                    'school_id'=>$old_student->school_id,
                                                    'order' => $old_student->order]);

                    $student_new->student_no = $this->generateStudentNo($student_new->id, $student_new->school_id);
                    $student_new->save();
                }
            }
        }
        DB::commit();

        return redirect()->back();
    }

}
