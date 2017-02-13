@extends('layouts.secure')

@section('title')
    {{ $title }}
@stop

@section('content')
    {!! Form::open(array('url' => url('/payment/'.$invoice->id.'/paypal/'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    {!! $invoice->title !!}
    <div class="form-group">
        @if (isset($invoice)) {{ $invoice->description }} @endif
    </div>
    <div class="form-group">
        {!! Form::label('amount', trans('invoice.amount') . ': ' . $invoice->amount . ' '. Settings::get('currency'), array('class' => 'control-label')) !!}
    </div>
    {!! Form::hidden('name', $invoice->title) !!}
    {!! Form::hidden('description', $invoice->description) !!}
    {!! Form::hidden('amount', $invoice->amount) !!}
    <div class="form-group">
        @if(strlen(Settings::get('paypal_signature'))>5)
            <button type="submit" class="btn btn-primary">
                {{ trans('invoice.pay_paypal')  }}
            </button>
        @endif
        {!! Form::close() !!}
        @if(strlen(Settings::get('stripe_secret'))>5 && strlen(Settings::get('payment_plan'))>2)
            {!! Form::open(array('url' => url('/payment/'.$invoice->id.'/stripe'), 'method' => 'post')) !!}
            <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{!!Settings::get('stripe_secret') !!}"
                    data-amount="{!! $invoice->amount*100 !!}"
                    data-name="{!! $invoice->title !!}"
                    data-description="{!! $invoice->description !!}"
                    data-locale="auto">
            </script>
            {!! Form::close() !!}
        @endif
    </div>
@endsection