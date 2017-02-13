<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\ExcelfileValidator;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Repositories\DirectionRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\MarkSystemRepository;
use App\Repositories\SubjectRepository;
use Datatables;
use Session;
use App\Http\Requests\Secure\SubjectRequest;


class SubjectController extends SecureController
{
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var DirectionRepository
     */
    private $directionRepository;
    /**
     * @var MarkSystemRepository
     */
    private $markSystemRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;

    /**
     * SubjectController constructor.
     * @param SubjectRepository $subjectRepository
     * @param DirectionRepository $directionRepository
     * @param MarkSystemRepository $markSystemRepository
     * @param ExcelRepository $excelRepository
     */
    public function __construct(SubjectRepository $subjectRepository,
                                DirectionRepository $directionRepository,
                                MarkSystemRepository $markSystemRepository,
                                ExcelRepository $excelRepository)
    {
        parent::__construct();

        $this->subjectRepository = $subjectRepository;
        $this->directionRepository = $directionRepository;
        $this->markSystemRepository = $markSystemRepository;
        $this->excelRepository = $excelRepository;

        view()->share('type', 'subject');
    }

    /**
     *
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $title = trans('subject.subjects');
        return view('subject.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('subject.new');
        $directions = $this->directionRepository->getAll()->pluck('title', 'id')->toArray();
        $mark_systems = $this->markSystemRepository->getAll()->pluck('title', 'id')->toArray();
        return view('layouts.create', compact('title', 'directions', 'mark_systems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|SubjectRequest $request
     * @return Response
     */
    public function store(SubjectRequest $request)
    {
        $this->subjectRepository->create($request->all());
        return redirect('/subject');
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @return Response
     * @internal param int $id
     */
    public function show(Subject $subject)
    {
        $title = trans('subject.details');
        $action = 'show';
        return view('layouts.show', compact('subject', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subject $subject
     * @return Response
     * @internal param int $id
     */
    public function edit(Subject $subject)
    {
        $title = trans('subject.edit');
        $directions = $this->directionRepository->getAll()->pluck('title', 'id')->toArray();
        $mark_systems = $this->markSystemRepository->getAll()->pluck('title', 'id')->toArray();
        return view('layouts.edit', compact('title', 'subject', 'directions', 'mark_systems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|SubjectRequest $request
     * @param Subject $subject
     * @return Response
     * @internal param int $id
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->all());
        return redirect('/subject');
    }

    public function delete(Subject $subject)
    {
        $title = trans('subject.delete');
        return view('/subject/delete', compact('subject', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     * @return Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect('/subject');
    }

    public function create_invoices(Subject $subject)
    {
        $last_school_year = SchoolYear::orderBy('id', 'DESC')->first();
        if (isset($last_school_year->id) && $subject->fee > 0) {
            $student_users = $this->subjectRepository->getAllStudentsSubjectAndDirection()
                ->where('subjects.id', $subject->id)
                ->where('students.school_year_id', $last_school_year->id)
                ->distinct('students.user_id')->select('students.user_id')->get();
            foreach ($student_users as $user) {
                $invoice = new Invoice();
                $invoice->title = trans("subject.fee");
                $invoice->description = trans("subject.subject_fee") . $subject->title;
                $invoice->amount = $subject->fee;
                $invoice->user_id = $user->user_id;
                $invoice->save();
            }
        }
        return redirect('/subject');
    }

    public function data()
    {
        $subjects = $this->subjectRepository->getAll()
            ->with('direction')
            ->orderBy('subjects.class')
            ->orderBy('subjects.order')
            ->get()
            ->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'order' => $subject->order,
                    'class' => $subject->class,
                    'mark_system' => isset($subject->mark_system->id) ? $subject->mark_system->title : "",
                    'title' => $subject->title,
                    'direction' => isset($subject->direction) ? $subject->direction->title : "",
                ];
            });

        return Datatables::of($subjects)
            ->add_column('actions', '<a href="{{ url(\'/subject/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/subject/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    <a href="{{ url(\'/subject/\' . $id . \'/create_invoices\' ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-money"></i>  {{ trans("subject.create_invoices") }}</a>
                                     <a href="{{ url(\'/subject/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }

    public function getImport()
    {
        $title = trans('subject.import_subject');

        return view('subject.import', compact('title'));
    }

    public function postImport(Request $request)
    {
        ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $subjects = $reader->all()->map(function ($row) {
            return [
                'title' => $row->title,
                'order' => $row->order,
                'class' => $row->class,
                'fee' => $row->fee,
            ];
        });

        $directions = $this->directionRepository->getAll()
            ->get()->map(function ($section) {
                return [
                    'text' => $section->title,
                    'id' => $section->id,
                ];
            })->values();

        $mark_systems = $this->markSystemRepository->getAll()
            ->get()->map(function ($section) {
                return [
                    'text' => $section->title,
                    'id' => $section->id,
                ];
            })->values();

        return response()->json(compact('subjects', 'directions', 'mark_systems'), 200);
    }

    public function postAjaxStore(SubjectRequest $request)
    {
        $this->subjectRepository->create($request->except('created', 'errors', 'selected'));

        return response()->json([], 200);
    }

    public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/subjects.xlsx'));
    }
}
