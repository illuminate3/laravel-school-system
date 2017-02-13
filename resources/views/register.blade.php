@extends('layouts.auth')
@section('content')
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <h3>{{trans('auth.create_account')}}</h3>
                <br>
                {!! Form::open(array('url' => url('signup'), 'method' => 'post')) !!}
                @if(Settings::get('generate_registration_code')==true && Settings::get('self_registration_role')=='student')
                    <div class="form-group required {{ $errors->has('registration_code') ? 'has-error' : '' }}">
                        {!! Form::label('registration_code',trans('auth.registration_code'), array('class'=>'required')) !!} :
                        <span class="help-block">{{ $errors->first('registration_code', ':message') }}</span>
                        {!! Form::text('registration_code', null, array('class' => 'form-control', 'required'=>'required')) !!}
                    </div>
                @endif
                <div class="form-group required {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    {!! Form::label('first_name',trans('auth.first_name'), array('class'=>'required')) !!} :
                    <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                    {!! Form::text('first_name', null, array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <div class="form-group required {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    {!! Form::label('last_name',trans('auth.last_name'), array('class'=>'required')) !!} :
                    <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                    {!! Form::text('last_name', null, array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email',trans('auth.email'), array('class'=>'required')) !!} :
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    {!! Form::email('email', null, array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
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
                    <button type="submit" class="btn btn-primary btn-block">{{trans('auth.register')}}</button>
                    <h5>{{trans('auth.have_account')}} <a href="{{ url('signin') }}" class="text-primary">{{trans("auth.login")}}</a></h5>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
    </div>
@stop