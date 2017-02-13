<?php

namespace App\Http\Controllers\Secure;

use App\Models\SchoolYear;
use App\Models\Semester;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SemesterRepository;
use Datatables;
use Session;
use App\Http\Requests\Secure\SemesterRequest;

class SemesterController extends SecureController
{
    /**
     * @var SchoolYearRepository
     */
    private $schoolYearRepository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;

    /**
     * SemesterController constructor.
     * @param SchoolYearRepository $schoolYearRepository
     * @param SemesterRepository $semesterRepository
     */
    public function __construct(SchoolYearRepository $schoolYearRepository,
                                SemesterRepository $semesterRepository)
    {
        parent::__construct();
        view()->share('type', 'semester');
        $this->schoolYearRepository = $schoolYearRepository;
        $this->semesterRepository = $semesterRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('semester.semesters');
        return view('semester.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('semester.new');
        $schoolyears = $this->schoolYearRepository->getAll()->pluck('title', 'id')->toArray();
        return view('layouts.create', compact('title', 'schoolyears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|SemesterRequest $request
     * @return Response
     */
    public function store(SemesterRequest $request)
    {
        $semester = new Semester($request->all());
        $semester->save();

        return redirect('/semester');
    }

    /**
     * Display the specified resource.
     *
     * @param Semester $semester
     * @return Response
     * @internal param int $id
     */
    public function show(Semester $semester)
    {
        $title = trans('semester.details');
        $action = 'show';
        return view('layouts.show', compact('semester', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Semester $semester
     * @return Response
     * @internal param int $id
     */
    public function edit(Semester $semester)
    {
        $title = trans('semester.edit');
        $schoolyears = $this->schoolYearRepository->getAll()->pluck('title', 'id')->toArray();
        return view('layouts.edit', compact('title', 'schoolyears', 'semester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SemesterRequest $request
     * @param Semester $semester
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SemesterRequest $request, Semester $semester)
    {
        $semester->update($request->all());
        return redirect('/semester');
    }

    /**
     * @param Semester $semester
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Semester $semester)
    {
        $title = trans('semester.delete');
        return view('/semester/delete', compact('semester', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Semester $semester
     * @return Response
     * @internal param int $id
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect('/semester');
    }

    public function data()
    {
        $semesters = $this->semesterRepository->getAll()
            ->with('school_year')
            ->get()
            ->map(function ($semester) {
                return [
                    'id' => $semester->id,
                    'title' => $semester->title,
                    'start' => $semester->start,
                    'end' => $semester->end,
                    'year' => isset($semester->school_year) ? $semester->school_year->title : "",
                ];
            });

        return Datatables::of($semesters)
            ->filterColumn('year', 'whereRaw', "school_years.title like ?", ["$1"])
            ->add_column('actions', '<a href="{{ url(\'/semester/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/semester/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/semester/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }
}
