<?php
namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Helpers\ExcelfileValidator;
use App\Http\Requests\Secure\StudentImportRequest;
use App\Helpers\Thumbnail;
use App\Models\Student;
use App\Models\UserDocument;
use App\Repositories\ExcelRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SectionRepository;
use App\Repositories\StudentRepository;
use Datatables;
use Illuminate\Http\Request;
use Session;
use DB;
use Sentinel;
use App\Http\Requests\Secure\StudentRequest;

class StudentController extends SecureController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;
    /**
     * @var SectionRepository
     */
    private $sectionRepository;

    /**
     * StudentController constructor.
     * @param StudentRepository $studentRepository
     * @param OptionRepository $optionRepository
     * @param ExcelRepository $excelRepository
     * @param SectionRepository $sectionRepository
     */
    public function __construct(StudentRepository $studentRepository,
                                OptionRepository $optionRepository,
                                ExcelRepository $excelRepository,
                                SectionRepository $sectionRepository)
    {
        parent::__construct();
        $this->studentRepository = $studentRepository;
        $this->optionRepository = $optionRepository;
        $this->excelRepository = $excelRepository;
        $this->sectionRepository = $sectionRepository;

        $this->middleware('authorized:student.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:student.create', ['only' => ['create', 'store', 'getImport', 'postImport', 'downloadTemplate']]);
        $this->middleware('authorized:student.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:student.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'student');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('student.student');
        return view('student.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('student.new');
        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->toArray();

        $document_types = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'student_document_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            });
        $custom_fields =  CustomFormUserFields::getCustomUserFields(6);
        return view('layouts.create', compact('title', 'sections', 'document_types','custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return Response
     */
    public function store(StudentRequest $request)
    {
        $user = $this->studentRepository->create($request->except('document', 'document_id','image_file'));

        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->picture = $picture;
            $user->save();
        }

        if ($request->hasFile('document') != "") {
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/documents/';
            $file->move($destinationPath, $document);

            UserDocument::where('user_id', $user->id)->delete();

            $userDocument = new UserDocument;
            $userDocument->user_id = $user->id;
            $userDocument->document = $document;
            $userDocument->option_id = $request->document_id;
            $userDocument->save();
        }
        CustomFormUserFields::storeCustomUserField(6, $user->id, $request);

        return redirect('/student');
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return Response
     */
    public function show(Student $student)
    {
        $title = trans('student.details');
        $action = 'show';
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues(6,$student->user_id);
        return view('layouts.show', compact('student', 'title', 'action','custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Student $student
     * @return Response
     */
    public function edit(Student $student)
    {
        $title = trans('student.edit');
        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()
            ->pluck('title', 'id')
            ->toArray();
        $document_types = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'student_document_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            });
        $documents = UserDocument::where('user_id', $student->user->id)->first();
        $custom_fields =  CustomFormUserFields::fetchCustomValues(6,$student->user_id);
        return view('layouts.edit', compact('title', 'student', 'sections', 'document_types', 'documents','custom_fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentRequest $request
     * @param Student $student
     * @return Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->only('section_id', 'order'));
        if ($request->password != "") {
            $student->user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $student->user->picture = $picture;
            $student->user->save();
        }

        $student->user->update($request->except('section_id', 'order', 'password', 'document', 'document_id','image_file'));

        if ($request->hasFile('document') != "") {
            $file = $request->file('document');
            $user = $student->user;
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/documents/';
            $file->move($destinationPath, $document);

            UserDocument::where('user_id', $user->id)->delete();

            $userDocument = new UserDocument;
            $userDocument->user_id = $user->id;
            $userDocument->document = $document;
            $userDocument->option_id = $request->document_id;
            $userDocument->save();
        }
        CustomFormUserFields::updateCustomUserField(6, $student->user->id, $request);

        return redirect('/student');
    }

    /**
     * @param Student $student
     * @return Response
     */
    public function delete(Student $student)
    {
        $title = trans('student.delete');
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues(6,$student->user_id);
        return view('/student/delete', compact('student', 'title','custom_fields'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect('/student');
    }

    public function data()
    {
        $students = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('user', 'section')
            ->orderBy('students.order')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'title' => isset($student->section) ? $student->section->title : "",
                    'full_name' => isset($student->user) ? $student->user->full_name : "",
                    'order' => $student->order,
                    'user_id' => $student->user_id
                ];
            });
        return Datatables::of($students)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'student.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/student/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/report/\' . $user_id . \'/forstudent\' ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-bar-chart"></i>  {{ trans("table.report") }}</a>
                                    <a href="{{ url(\'/student/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/student_card/\' . $user_id ) }}" target="_blank" class="btn btn-success btn-sm" >
                                            <i class="fa fa-credit-card"></i>  {{ trans("student.student_card") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'student.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/student/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                      @endif')
            ->remove_column('id')
            ->remove_column('user_id')
            ->make();
    }

    public function getImport()
    {
        $title = trans('student.import_student');

        return view('student.import', compact('title'));
    }

    public function postImport(Request $request)
    {
        ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $students = $reader->all()->map(function ($row) {
            return [
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                'password' => $row->password,
                'mobile' => $row->mobile,
                'fax' => $row->fax,
                'birth_date' => $row->birth_date,
                'birth_place' => $row->birth_place,
                'address' => $row->address,
                'order' => $row->order,
            ];
        });

        $sections = $this->sectionRepository
            ->getAllForSchoolYearSchool(session('current_school_year'), session('current_school'))
            ->get()->map(function ($section) {
                return [
                    'text' => $section->title,
                    'id' => $section->id,
                ];
            })->values();

        return response()->json(compact('students', 'sections'), 200);
    }

    public function postAjaxStore(StudentImportRequest $request)
    {
        $this->studentRepository->create($request->except('created', 'errors', 'selected'));

        return response()->json([], 200);
    }

    public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/students.xlsx'));
    }

}
