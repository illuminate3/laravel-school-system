<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Models\Invoice;
use App\Repositories\FeeCategoryRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\StudentRepository;
use Datatables;
use Efriandika\LaravelSettings\Facades\Settings;
use Session;
use DB;
use App\Http\Requests\Secure\InvoiceRequest;
use Illuminate\Support\Facades\App;

class InvoiceController extends SecureController
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var FeeCategoryRepository
     */
    private $feeCategoryRepository;

    /**
     * InvoiceController constructor.
     * @param InvoiceRepository $invoiceRepository
     * @param StudentRepository $studentRepository
     * @param FeeCategoryRepository $feeCategoryRepository
     */
    public function __construct(InvoiceRepository $invoiceRepository,
                                StudentRepository $studentRepository,
                                FeeCategoryRepository $feeCategoryRepository)
    {
        parent::__construct();

        $this->invoiceRepository = $invoiceRepository;
        $this->studentRepository = $studentRepository;
        $this->feeCategoryRepository = $feeCategoryRepository;

        $this->middleware('authorized:invoice.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:invoice.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:invoice.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:invoice.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'invoice');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $title = trans('invoice.invoice');
        return view('invoice.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $title = trans('invoice.new');
        $this->generateParams();

        return view('layouts.create', compact('title'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param InvoiceRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function store(InvoiceRequest $request)
    {
        foreach ($request['user_id'] as $user_id) {
            $invoice = new Invoice($request->except('user_id'));
            $invoice->user_id = $user_id;
            $invoice->save();
        }
        return redirect('/invoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  Invoice $invoice
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        $data = '<h1>' . trans('invoice.details') . '</h1>
                        ' . trans('invoice.title') . ': ' . $invoice->title . '<br>
                        ' . trans('invoice.description') . ': ' . $invoice->description . '<br>
                        ' . trans('invoice.amount') . ': ' . $invoice->amount . '<br>
                        ' . trans('invoice.student') . ': ' . $invoice->user->first_name . ' ' . $invoice->user->last_name . '<br>';
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->loadView('report.invoice', compact('data'));
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Invoice $invoice
     * @return Response
     */
    public function edit(Invoice $invoice)
    {
        $title = trans('invoice.edit');
        $this->generateParams();

        return view('layouts.edit', compact('title', 'invoice'));
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param InvoiceRequest $request
	 * @param  Invoice $invoice
	 *
	 * @return Response
	 */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());
        return redirect('/invoice');
    }

    /**
     *
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function delete(Invoice $invoice)
    {
        $title = trans('invoice.delete');
        return view('/invoice/delete', compact('invoice', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Invoice $invoice
     * @return Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect('/invoice');
    }

    public function data()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')){
		    $invoices = $this->invoiceRepository->getAllStudentsForSchool(Session::get( 'current_school' ));
	    }else{
		    $invoices = $this->invoiceRepository->getAll();
	    }
	    $invoices = $invoices->with('user')
            ->get()
            ->map(function ($invoice) {
                return [
                    "id" => $invoice->id,
                    "title" => $invoice->title,
                    "name" => isset($invoice->user) ? $invoice->user->full_name : "",
                    "amount" => $invoice->amount,
                ];
            });
        return Datatables::of($invoices)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'invoice.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/invoice/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a target="_blank" href="{{ url(\'/invoice/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'invoice.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/invoice/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->remove_column('id')
            ->make();
    }

    /**
     * @return mixed
     */
    private function generateParams()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school && $this->user->inRole('accountant')){
		    $students = $this->studentRepository->getAllForSchoolYearAndSchool( Session::get( 'current_school_year' ), Session::get( 'current_school' ))
                                ->with( 'user' )
                                ->get()
                                ->map( function ( $item ) {
                                    return [
                                        "id"   => $item->user_id,
                                        "name" => isset( $item->user ) ? $item->user->full_name : "",
                                    ];
                                } )->pluck( "name", 'id' )->toArray();
	    }else {
		    $students = $this->studentRepository->getAllForSchoolYear( Session::get( 'current_school_year' ) )
	                            ->with( 'user' )
	                            ->get()
	                            ->map( function ( $item ) {
	                                return [
	                                    "id"   => $item->user_id,
	                                    "name" => isset( $item->user ) ? $item->user->full_name : "",
	                                ];
	                            } )->pluck( "name", 'id' )->toArray();
	    }
        view()->share('students', $students);

        $fee_categories = $this->feeCategoryRepository->getAll()
            ->get()
            ->map(function ($item) {
                return [
                    "id" => $item->user_id,
                    "title" => $item->title,
                ];
            })->pluck("title", 'id')->toArray();
        view()->share('fee_categories', $fee_categories);
    }

}
