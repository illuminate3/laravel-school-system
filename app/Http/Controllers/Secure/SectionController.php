<?php

namespace App\Http\Controllers\Secure;

use App\Models\Invoice;
use App\Http\Requests;
use App\Models\Section;
use App\Models\StudentGroup;
use App\Models\StudentRegistrationCode;
use App\Repositories\SectionRepository;
use App\Repositories\StudentGroupRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherSchoolRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Sentinel;
use Datatables;
use Session;
use DB;
use App\Http\Requests\Secure\SectionRequest;

class SectionController extends SecureController
{
    /**
     * @var SectionRepository
     */
    private $sectionRepository;
    /**
     * @var TeacherSchoolRepository
     */
    private $teacherSchoolRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var StudentGroupRepository
     */
    private $studentGroupRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;

    /**
     * SectionController constructor.
     * @param SectionRepository $sectionRepository
     * @param TeacherSchoolRepository $teacherSchoolRepository
     * @param StudentRepository $studentRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @param SubjectRepository $subjectRepository
     */
    public function __construct(SectionRepository $sectionRepository,
                                TeacherSchoolRepository $teacherSchoolRepository,
                                StudentRepository $studentRepository,
                                StudentGroupRepository $studentGroupRepository,
                                SubjectRepository $subjectRepository)
    {
        parent::__construct();

        $this->sectionRepository = $sectionRepository;
        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->studentRepository = $studentRepository;
        $this->studentGroupRepository = $studentGroupRepository;
        $this->subjectRepository = $subjectRepository;

        $this->middleware('authorized:section.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:section.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:section.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:section.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'section');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('section.section');
        return view('section.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('section.new');
        $teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school'))
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->full_name,
                ];
            })
            ->pluck('name', 'id')
            ->toArray();
        return view('layouts.create', compact('title', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SectionRequest $request)
    {
        $section = new Section($request->all());
        $section->school_id = session('current_school');
        $section->save();
        return redirect('/section');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Section $section)
    {
        $title = trans('section.details');
        $action = 'show';
        return view('layouts.show', compact('section', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Section $section)
    {
        $title = trans('section.edit');
        $teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school'))
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'name' => $teacher->full_name,
                ];
            })
            ->pluck('name', 'id')
            ->toArray();
        return view('layouts.edit', compact('title', 'section', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $section->update($request->all());
        return redirect('/section');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(Section $section)
    {
        $title = trans('section.delete');
        return view('/section/delete', compact('section', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect('/section');
    }

    public function make_invoices(Section $section)
    {
        $student_users = $this->subjectRepository->getAllStudentsSubjectAndDirection()
            ->where('students.section_id', $section->id)
            ->where('students.school_year_id', session('current_school_year'))
            ->where('students.school_id', session('current_school'))
            ->where('subjects.fee', '>', 0)
            ->distinct('students.user_id')->select('students.user_id', 'subjects.title as subject', 'subjects.fee')
            ->get();
        foreach ($student_users as $user) {
            $invoice = new Invoice();
            $invoice->title = trans("subject.fee");
            $invoice->description = trans("subject.subject_fee") . $user->subject;
            $invoice->amount = $user->fee;
            $invoice->user_id = $user->user_id;
            $invoice->save();
        }
        return redirect('/section');
    }

    public function generate_code(Section $section)
    {
        $quantity = $section->quantity;
        if($quantity>0 && ($quantity - $section->total->count()) > 0 ) {
            $count = $quantity - $section->total->count();
            StudentRegistrationCode::where('school_year_id', $section->school_year_id)
                ->where('school_id', $section->school_id)
                ->where('section_id', $section->id)->delete();
            $code_lists = [];
            for ($i = 0; $i < $count; $i++) {
                $code = $this->generateUniqueCode();
                $code_lists[] = $code;
                StudentRegistrationCode::create(['school_year_id' => $section->school_year_id,
                    'school_id' => $section->school_id,
                    'section_id' => $section->id,
                    'code' => $code]);
            }
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper('a4', 'landscape');

            $content = '<table>';
            foreach (array_chunk($code_lists, 4) as $codeRow) {
                $content .= '<tr>';
                foreach ($codeRow as $code) {
                    $content .= '<td>' . $code . '</td>';
                }
                $content .= '</tr>';
            }
            $content .= '</table>';

            $pdf->loadView('report.code_lists', compact('content'));
            return $pdf->stream();
        }
        return redirect('/section');
    }

    private function generateUniqueCode()
    {
        $code = str_random(10);
        $student_registration_code = StudentRegistrationCode::where('code', $code)->first();
        if(is_null($student_registration_code)){
            return $code;
        }else{
            $this->generateUniqueCode();
        }
    }

    public function data()
    {
        $sections = $this->sectionRepository->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->with('teacher')
            ->get()
            ->map(function ($section) {
                return [
                    'id' => $section->id,
                    'title' => $section->title,
                    'quantity' => $section->quantity,
                    'total' => $section->total->count(),
                    'full_name' => isset($section->teacher) ? $section->teacher->full_name : "",
                ];
            });

        return Datatables::of($sections)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'section.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/section/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/section/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/section/\' . $id . \'/generate_csv\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-file-excel-o"></i>  {{ trans("section.generate_csv") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'student_group.show\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/section/\' . $id . \'/groups\' ) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-list-ul"></i> {{ trans("section.groups") }}</a>
                                     @endif
                                     <a href="{{ url(\'/section/\' . $id . \'/students\' ) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-users"></i> {{ trans("section.students") }}</a>
                                     <a href="{{ url(\'/section/\' . $id . \'/make_invoices\' ) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-money"></i> {{ trans("section.make_invoices") }}</a>
                                     @if(Settings::get(\'generate_registration_code\')==true && Settings::get(\'self_registration_role\')==\'student\')
                                        <a target="_blank" href="{{ url(\'/section/\' . $id . \'/generate_code\' ) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-list-alt"></i> {{ trans("section.generate_code") }}</a>
                                     @endif
                                     @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'section.delete\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/section/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->remove_column('id')
            ->make();
    }
    public function generateCsvStudentsSection(Section $section){

        $students = $this->studentRepository->getAllForSchoolYearAndSection(session('current_school_year'), $section->id)
            ->orderBy('order')
            ->with('user')
            ->get()
            ->filter(function ($student){
                return isset($student->user);
            })
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function groups(Section $section)
    {
        $title = trans('section.groups');
        $id = $section->id;
        return view('section.groups', compact('title', 'id'));
    }

    public function groups_data(Section $section)
    {
        $studentGroups = $this->studentGroupRepository->getAllForSection($section->id)
            ->with('direction')
            ->get()
            ->map(function ($studentGroup) {
                return [
                    'id' => $studentGroup->id,
                    'title' => $studentGroup->title,
                    'direction' => isset($studentGroup->direction) ? $studentGroup->direction->title : "",
                    'class' => $studentGroup->class
                ];
            });

        return Datatables::of($studentGroups)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'student_group.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/studentgroup/' . $section->id . '/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/studentgroup/' . $section->id . '/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/studentgroup/\' . $id . \'/generate_csv\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-file-excel-o"></i>  {{ trans("section.generate_csv") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'student_group.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/studentgroup/' . $section->id . '/\' . $id . \'/students\' ) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-users"></i> {{ trans("section.students") }}</a>
                                     <a href="{{ url(\'/studentgroup/' . $section->id . '/\' . $id . \'/subjects\' ) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-list-ol"></i> {{ trans("section.subjects") }}</a>
                                     <a href="{{ url(\'/studentgroup/' . $section->id . '/\' . $id . \'/timetable\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-calendar"></i>  {{ trans("studentgroup.timetable") }}</a>
                                    @endif
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'student_group.delete\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/studentgroup/' . $section->id . '/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif')
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function students(Section $section)
    {
        $title = trans('section.students');
        $id = $section->id;
        return view('section.students', compact('title', 'id'));
    }

    public function students_data(Section $section)
    {
        $students = $this->studentRepository
            ->getAllForSchoolYearAndSection(session('current_school_year'), $section->id)
            ->with('user')
            ->orderBy('students.order')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'full_name' => isset($student->user) ? $student->user->full_name : "",
                    'order' => $student->order,
                ];
            });

        return Datatables::of($students)
            ->add_column('actions', '<a href="{{ url(\'/student/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/student/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/student/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }
}
