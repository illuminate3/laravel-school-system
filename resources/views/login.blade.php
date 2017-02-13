@extends('layouts.auth')
@section('content')
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <h3>{{trans('auth.sign_account')}}</h3>
                <br>
                {!! Form::open(array('url' => url('signin'), 'method' => 'post', 'name' => 'form')) !!}
                <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email',trans('auth.email'), array('class' => 'control-label required')) !!} :
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    {!! Form::email('email', null, array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password',trans('auth.password'), array('class' => 'control-label required')) !!} :
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    {!! Form::password('password', array('class' => 'form-control', 'required'=>'required')) !!}
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{trans('auth.login')}}</button>
                {!! Form::close() !!}
                <div class="text-center">
                    <h5><a href="{{url('passwordreset')}}" class="text-primary">{{trans('auth.forgot')}}?</a></h5>
                    @if(Settings::get('self_registration')=='yes')
                        <h5><a href="{{url('signup')}}" class="text-primary">{{trans('auth.create_account')}}</a>
                        </h5>
                    @endif
                </div>
            </section>
        </div>
    </div>
@stop