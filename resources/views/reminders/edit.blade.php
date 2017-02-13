@extends('layouts.auth')
@section('content')
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <h3>{{trans('auth.set_new_password')}}</h3>
                {!! Form::open(['reminders.update', $id, $code]) !!}
                <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password',trans('auth.password'), array('class'=>'required')) !!} :
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    {!! Form::password('password', array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <div class="form-group required {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    {!! Form::label('password_confirmation',trans('auth.password_confirmation'), array('class'=>'required')) !!} :
                    <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
                    {!! Form::password('password_confirmation', array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">{{trans('auth.reset')}}</button>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
    </div>
@stop