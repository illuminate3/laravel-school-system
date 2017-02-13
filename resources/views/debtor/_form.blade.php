<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
            {!! Form::label('message', trans('debtor.message'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('message', null, array('message' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('sms_email') ? 'has-error' : '' }}">
            {!! Form::label('sms_email', trans('debtor.sms_email'), array('class' => 'control-label required')) !!}
            <div class="controls radiobutton">
                {!! Form::label('sms_email', trans('debtor.email'), array('class' => 'control-label')) !!}
                {!! Form::radio('sms_email', '0') !!}
                @if(Settings::get('sms_driver')!="")
                    {!! Form::label('sms_email', trans('debtor.sms'), array('class' => 'control-label')) !!}
                    {!! Form::radio('sms_email', '1') !!}
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
            {!! Form::label('user_id', trans('debtor.student'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('user_id[]', $debtors, null, array('id'=>'user_id', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
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
