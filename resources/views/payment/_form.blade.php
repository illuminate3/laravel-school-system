<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($payment))
            {!! Form::model($payment, array('url' => url($type) . '/' . $payment->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
            {!! Form::label('invoice', $payment->title, array('class' => 'control-label')) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
            <div class="form-group {{ $errors->has('invoice_id') ? 'has-error' : '' }}">
                {!! Form::label('invoice_id', trans('payment.invoice'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('invoice_id', $invoices, null, array('id'=>'invoice_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('invoice_id', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('payment_method') ? 'has-error' : '' }}">
            {!! Form::label('payment_method', trans('payment.payment_method'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('payment_method', $payment_method, null, array('id'=>'payment_method', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('payment_method', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            {!! Form::label('status', trans('payment.status_payment'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('status', $status_payment, null, array('id'=>'status', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('status', ':message') }}</span>
            </div>
        </div>

        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>


        {!! Form::close() !!}
    </div>
</div>
