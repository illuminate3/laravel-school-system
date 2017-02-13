@extends('layouts.install')
@section('content')
    {!! Form::open(['url' => 'install/email_settings']) !!}
    <div class="step-content" style="padding-left: 15px; padding-top: 15px">
        <h3>{{trans('install.mail_settings')}}</h3>
        <hr>
        <div class="form-group required {{ $errors->has('email_driver') ? 'has-error' : '' }}">
            {!! Form::label('email_driver', trans('settings.email_driver'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="form-inline">
                    <div class="radio">
                        {!! Form::radio('email_driver', 'mail',true, array('id'=>'mail', 'class'=>'email_driver'))  !!}
                        {!! Form::label('mail', 'MAIL')  !!}
                    </div>
                    <div class="radio">
                        {!! Form::radio('email_driver', 'smtp', false, array('id'=>'smtp', 'class'=>'email_driver'))  !!}
                        {!! Form::label('smtp', 'SMTP') !!}
                    </div>
                </div>
                <span class="help-block">{{ $errors->first('email_driver', ':message') }}</span>
            </div>
        </div>
        <div class="form-group smtp required {{ $errors->has('email_host') ? 'has-error' : '' }}">
            {!! Form::label('email_host', trans('settings.email_host'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('text','email_host', old('email_host'), array('class' => 'form-control input-sm')) !!}
                <span class="help-block">{{ $errors->first('email_host', ':message') }}</span>
            </div>
        </div>
        <div class="form-group smtp required {{ $errors->has('email_port') ? 'has-error' : '' }}">
            {!! Form::label('email_port', trans('settings.email_port'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('text','email_port', old('email_port'), array('class' => 'form-control input-sm')) !!}
                <span class="help-block">{{ $errors->first('email_port', ':message') }}</span>
            </div>
        </div>
        <div class="form-group smtp required {{ $errors->has('email_username') ? 'has-error' : '' }}">
            {!! Form::label('email_username', trans('settings.email_username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('text','email_username', old('email_username'), array('class' => 'form-control input-sm')) !!}
                <span class="help-block">{{ $errors->first('email_username', ':message') }}</span>
            </div>
        </div>
        <div class="form-group smtp required {{ $errors->has('email_password') ? 'has-error' : '' }}">
            {!! Form::label('email_password', trans('settings.email_password'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('text','email_password', old('email_password'), array('class' => 'form-control input-sm')) !!}
                <span class="help-block">{{ $errors->first('email_password', ':message') }}</span>
            </div>
        </div>
        <button class="btn btn-success pull-right">
            {{trans('install.finish')}}
            <i class="fa fa-arrow-right"></i>
        </button>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
@stop
@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('.smtp').hide();
            $('.email_driver').change(function () {
                if ($(this).filter(':checked').val() == 'smtp') {
                    $('.smtp').show();
                }
                else {
                    $('.smtp').hide();
                }
            });
        })
    </script>
@stop