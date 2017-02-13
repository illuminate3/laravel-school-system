<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;
use Omnipay\Omnipay;
use App\Http\Requests\Secure\PaymentRequest;
use App\Http\Requests\Secure\PayRequest;

class PaymentController extends SecureController
{
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * PaymentController constructor.
     * @param PaymentRepository $paymentRepository
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(PaymentRepository $paymentRepository,
                                InvoiceRepository $invoiceRepository)
    {
        parent::__construct();

        $this->paymentRepository = $paymentRepository;
        $this->invoiceRepository = $invoiceRepository;

        $this->middleware('authorized:payment.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:payment.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:payment.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:payment.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'payment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('payment.payment');

        $total_payment = Payment::sum('amount');
        $total_invoice = Invoice::sum('amount');

        $payments = array(array('title' => trans('payment.total_payment'), 'items' => $total_payment, 'color' => "#0D47A1"),
            array('title' => trans('payment.total_invoice'), 'items' => $total_invoice, 'color' => "#00838F"));


        return view('payment.index', compact('title', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->generateParam();
        $title = trans('payment.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PaymentRequest $request)
    {
        $invoice = Invoice::find($request['invoice_id']);

        $payment = new Payment($request->all());
        $payment->save();

        if ($request->status == 'payed') {
            $invoice->paid = 1;
            $invoice->save();
        }

        return redirect('/payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Payment $payment)
    {
        $title = trans('payment.details');
        $action = 'show';
        return view('layouts.show', compact('payment', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Payment $payment)
    {
        $title = trans('payment.edit');
        $this->generateParam();
        return view('layouts.edit', compact('title', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $invoice = Invoice::find($payment->invoice_id);

        $payment->update($request->all());

        if ($request->status == 'payed') {
            $invoice->paid = 1;
            $invoice->save();
        }
        return redirect('/payment');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(Payment $payment)
    {
        $title = trans('payment.delete');
        return view('/payment/delete', compact('payment', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect('/payment');
    }

    public function data()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')){
		    $payments = $this->paymentRepository->getAllStudentsForSchool(Session::get( 'current_school' ));
	    }else{
		    $payments = $this->paymentRepository->getAll();
	    }
	    $payments = $payments->with('user')->get()
            ->map(function ($payment) {
                return [
                    "id" => $payment->id,
                    "title" => $payment->title,
                    "payment_method" => $payment->payment_method,
                    "name" => isset($payment->user) ? $payment->user->full_name : "",
                    "amount" => $payment->amount,
                    "status" => $payment->status,
                ];
            });

        return Datatables::of($payments)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'payment.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/payment/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/payment/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'payment.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/payment/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif')
            ->remove_column('id')
            ->make();
    }

    private function generateParam()
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
                    "title" => $invoice->title . '(' . $invoice->amount . ') ' . (isset($invoice->user) ? $invoice->user->full_name : ""),
                ];
            })
            ->pluck('title', 'id')->toArray();
        $payment_method = Option::where('category', 'payment_methods')->pluck('title', 'value')->toArray();
        $status_payment = Option::where('category', 'status_payment')->pluck('title', 'value')->toArray();

        view()->share('invoices', $invoices);
        view()->share('payment_method', $payment_method);
        view()->share('status_payment', $status_payment);
    }

    public function pay(Invoice $invoice)
    {
        $title = trans('payment.pay_invoice');
        return view('/payment.pay', compact('invoice', 'title'));
    }

    public function paypalPayment(Invoice $invoice, PayRequest $request)
    {

        $params = array(
            'cancelUrl' => url('/payment/' . $invoice->id . '/paypal_cancel'),
            'returnUrl' => url('/payment/' . $invoice->id . '/paypal_success'),
            'name' => $invoice->title,
            'description' => $invoice->description,
            'amount' => $invoice->amount,
            'currency' => Settings::get('currency')
        );

        session(['params' => $params]);

        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(Settings::get('paypal_username'));
        $gateway->setPassword(Settings::get('paypal_password'));
        $gateway->setSignature(Settings::get('paypal_signature'));
        $gateway->setTestMode(Settings::get('paypal_testmode'));

        $response = $gateway->purchase($params)->send();

        if ($response->isSuccessful()) {
            // payment was successful: update database
        } elseif ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
        }
    }

    public function paypalSuccess(Invoice $invoice)
    {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(Settings::get('paypal_username'));
        $gateway->setPassword(Settings::get('paypal_password'));
        $gateway->setSignature(Settings::get('paypal_signature'));
        $gateway->setTestMode(Settings::get('paypal_testmode'));

        $params = session('params');

        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData();
        $title = "";
        if (isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {

            $payment = new Payment();
            $payment->title = $invoice->title;
            $payment->description = $invoice->description;
            $payment->invoice_id = $invoice->id;
            $payment->amount = $paypalResponse['PAYMENTINFO_0_AMT'];
            $payment->status = $paypalResponse['PAYMENTINFO_0_PAYMENTSTATUS'];
            $payment->paykey = $paypalResponse['TOKEN'];
            $payment->timestamp = $paypalResponse['TIMESTAMP'];
            $payment->correlation_id = $paypalResponse['CORRELATIONID'];
            $payment->ack = $paypalResponse['ACK'];
            $payment->transaction_id = $paypalResponse['PAYMENTINFO_0_TRANSACTIONID'];
            $payment->status = $paypalResponse['ACK'];
            $payment->payment_method = 'Paypal';
            $payment->user_id = $invoice->user_id;
            $payment->save();

            $invoice->paid = ($paypalResponse['ACK'] == 'Success' || $paypalResponse['ACK'] == 'SuccessWithWarning') ? 1 : 0;
            $invoice->save();

            return redirect('/studentsection/payment');

        } else {
            $title = "Error";
        }
        return view('result', compact('paypalResponse', 'title'));
    }

    public function stripe(Invoice $invoice, Request $request)
    {
        $creditCardToken = $request->stripeToken;
        $payment = new Payment();
        $payment->newSubscription('main', Settings::get('payment_plan'))->create($creditCardToken);
        $payment->title = $invoice->title;
        $payment->description = $invoice->description;
        $payment->invoice_id = $invoice->id;
        $payment->amount = $invoice->amount;
        $payment->status = "Payed";
        $payment->payment_method = 'Stripe';
        $payment->user_id = $invoice->user_id;
        $payment->save();

        $invoice->paid = 1;
        $invoice->save();

        return redirect('/studentsection/payment');
    }

}
