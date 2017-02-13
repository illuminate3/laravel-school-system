@extends('layouts.install')
@section('content')
    {!! Form::open(array('url' =>  'install/settings', 'method' => 'post')) !!}
    <div class="step-content" style="padding-left: 15px; padding-top: 15px">
        <h3>{{trans('install.settings')}}</h3>
        <hr>
        <div class="form-group required {{ $errors->has('multi_school') ? 'has-error' : '' }}">
            {!! Form::label('multi_school', trans('install.multi_school'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="form-inline">
                    <div class="radio">
                        {!! Form::radio('multi_school', 'yes',true, array('id'=>'yes', 'class'=>'multi_school'))  !!}
                        {!! Form::label('yes', 'YES')  !!}
                    </div>
                    <div class="radio">
                        {!! Form::radio('multi_school', 'no',false , array('id'=>'no', 'class'=>'multi_school'))  !!}
                        {!! Form::label('no', 'NO') !!}
                    </div>
                </div>
                <span class="help-block">{{ $errors->first('multi_school', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('currency') ? 'has-error' : '' }}">
            {!! Form::label('currency', trans('settings.currency'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('currency', $currency, old('currency'), array('id'=>'currency','class' => 'form-control input-sm select2')) !!}
                <span class="help-block">{{ $errors->first('currency', ':message') }}</span>
            </div>
        </div>
        <div id="one-school">
            <legend>{{trans('install.school_info')}}</legend>
            <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{trans('install.school_title')}}</label>
                <div class="controls">
                    {!! Form::text('title', old('title'),array('class' => 'form-control input-sm')) !!}
                    <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                </div>
            </div>
            <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="school_email">{{trans('install.school_email')}}</label>
                <div class="controls">
                    {!! Form::text('school_email', old('school_email'),array('class' => 'form-control input-sm')) !!}
                    <span class="help-block">{{ $errors->first('school_email', ':message') }}</span>
                </div>
            </div>
            <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="phone">{{trans('install.school_phone')}}</label>
                <div class="controls">
                    {!! Form::text('phone', old('phone'),array('class' => 'form-control input-sm')) !!}
                    <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                </div>
            </div>
            <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{trans('install.school_address')}}</label>
                <div class="controls">
                    {!! Form::text('address', old('address'),array('class' => 'form-control input-sm')) !!}
                    <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                </div>
            </div>
        </div>
        <legend id="admin">{{trans('install.super_admin')}}</legend>
        <div class="form-group required {{ $errors->has('first_name') ? 'has-error' : '' }}">
            <label for="first_name">{{trans('install.first_name')}}</label>
            <div class="controls">
                {!! Form::text('first_name', old('first_name'),array('class' => 'form-control input-sm')) !!}
                <small>{{trans('install.first_name_info')}}</small>
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('last_name') ? 'has-error' : '' }}">
            <label for="last_name">{{trans('install.last_name')}}</label>
            <div class="controls">
                {!! Form::text('last_name', old('last_name'),array('class' => 'form-control input-sm')) !!}
                <small>{{trans('install.last_name_info')}}</small>
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">{{trans('install.email')}}</label>
            <div class="controls">
                {!! Form::text('email', old('email'),array('class' => 'form-control input-sm')) !!}
                <small>{{trans('install.email_info')}}</small>
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">{{trans('install.password')}}</label>
            <div class="controls">
                {!! Form::password('password', array('class' => 'form-control input-sm')) !!}
                <small>{{trans('install.password_info2')}}</small>
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label for="password">{{trans('install.password_confirmation')}}</label>
            <div class="controls">
                {!! Form::password('password_confirmation', array('class' => 'form-control input-sm')) !!}
                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
            </div>
        </div>
        <button class="btn btn-success pull-right">
            {{trans('install.next')}}
            <i class="fa fa-arrow-right"></i>
        </button>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
@stop
@section('scripts')
    <script>
        jQuery(document).ready(function($) {
            $('#one-school').hide();
            $('.multi_school').change(function () {
                if($(this).filter(':checked').val()=='yes')
                {
                    $('#one-school').hide();
                }
                else {
                    $('#one-school').show();
                }
            });
        })
    </script>
@stop