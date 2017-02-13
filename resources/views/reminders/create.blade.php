@extends('layouts.auth')
@section('content')
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <h3>{{trans('auth.forgot_password')}}</h3>
                <p>{{trans('auth.enter_email_reset_password')}}</p>
                @if (Session::has('email_message_warning'))
                    <div class="alert alert-danger">{{ session('email_message_warning') }}</div>
                @endif
                @if (Session::has('email_message_success'))
                    <div class="alert alert-success">{{ session('email_message_success') }}</div>
                @endif
                {!! Form::open(array('url' => url('passwordreset'), 'method' => 'post', 'name' => 'form')) !!}
                <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="sr-only"></label>
                    <div class="controls">
                        {!! Form::text('email', null, array('class' => 'form-control','placeholder'=>trans("auth.email"))) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">{{trans('auth.reset_your_password')}}</button>
                    <h5>
                        {{trans('auth.have_account')}}
                        <a href="{{ url('signin') }}" class="text-primary">{{trans("auth.login")}}</a>
                    </h5>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
    </div>
@stop