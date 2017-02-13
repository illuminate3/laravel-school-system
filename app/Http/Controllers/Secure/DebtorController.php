<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Http\Requests\Secure\DebtorRequest;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\SmsMessage;
use App\Models\User;
use App\Repositories\FeeCategoryRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\StudentRepository;
use Datatables;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\Mail;
use Session;
use DB;
use App\Http\Requests\Secure\InvoiceRequest;
use Illuminate\Support\Facades\App;
use SimpleSoftwareIO\SMS\Facades\SMS;

class DebtorController extends SecureController
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * InvoiceController constructor.
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        parent::__construct();

        $this->invoiceRepository = $invoiceRepository;

        $this->middleware('authorized:debtor.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:debtor.create', ['only' => ['create', 'store']]);

        view()->share('type', 'debtor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('debtor.debtor');
        return view('debtor.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('debtor.new');
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')){
		    $debtors = $this->invoiceRepository->getAllDebtorStudentsForSchool(Session::get( 'current_school' ));
	    }else{
		    $debtors = $this->invoiceRepository->getAllDebtor();
	    }
	    $debtors = $debtors->with('user')
            ->get()
            ->map(function ($debtor) {
                return [
                    "id" => $debtor->user_id,
                    "name" => isset($debtor->user) ? $debtor->user->full_name : "",
                ];
            })->pluck('name', 'id');

        return view('layouts.create', compact('title', 'debtors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(DebtorRequest $request)
    {
        foreach ($request['user_id'] as $item) {
            $user = User::find($item);

            if ($request->sms_email == 1) {

                $smsMessage = new SmsMessage();
                $smsMessage->text = $request->message;
                $smsMessage->number = $user->mobile;
                $smsMessage->user_id = $item;
                $smsMessage->user_id_sender = $this->user->id;
                $smsMessage->save();

                SMS::send($request->message, [], function ($sms) use ($user) {
                    $sms->to($user->mobile);
                });
            } else {
                $email = new Message();
                $email->user_id_receiver = $item;
                $email->user_id_sender = $this->user->id;
                $email->content = $request->message;
                $email->title = trans('debtor.debtor_message');
                $email->save();

                if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
                    Mail::send('emails.contact', array('user' => $user->first_name . ' ' . $user->last_name,
                        'bodyMessage' => $request->message),
                        function ($m)
                        use ($user, $request) {
                            $m->from(Settings::get('site_email'), Settings::get('site_name'));
                            $m->to($user->email)->subject(trans('debtor.debtor_message'));
                        });
                }
            }
        }
        return redirect('/debtor');
    }

    public function data()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')){
		    $debtors = $this->invoiceRepository->getAllDebtorStudentsForSchool(Session::get( 'current_school' ));
	    }else{
		    $debtors = $this->invoiceRepository->getAllDebtor();
	    }
	    $debtors = $debtors->with('user')
            ->get()
            ->map(function ($debtor) {
                return [
                    "id" => $debtor->id,
                    "name" => isset($debtor->user) ? $debtor->user->full_name : "",
                    "amount" => $debtor->amount,
                ];
            });
        return Datatables::of($debtors)
            ->remove_column('id')
            ->make();
    }

}
