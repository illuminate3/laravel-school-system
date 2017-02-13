<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($invoice))
            {!! Form::model($invoice, array('url' => url($type) . '/' . $invoice->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('invoice.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('invoice.description'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            {!! Form::label('amount', trans('invoice.amount'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('amount', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('amount', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('fee_category_id') ? 'has-error' : '' }}">
            {!! Form::label('fee_category_id', trans('invoice.fee_category_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('fee_category_id', $fee_categories, null, array('id'=>'fee_category_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('fee_category_id', ':message') }}</span>
            </div>
        </div>
        @if (isset($invoice))
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('invoice.student'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id', $students, null, array('id'=>'user_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                </div>
            </div>
        @else
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('invoice.student'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id[]', $students, null, array('id'=>'user_id', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                </div>
            </div>
        @endif

        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>


        {!! Form::close() !!}
    </div>
</div>
