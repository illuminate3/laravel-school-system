@extends('layouts.install')
@section('content')
    {!! Form::open(array('url' =>  'install/verify', 'method' => 'post')) !!}
    <div class="step-content" style="padding-left: 15px; padding-top: 15px; padding-right: 15px">
        <h3>{{trans('install.verification')}}</h3>
        <hr>
        <div class="form-group {{ $errors->has('purchase_code') ? 'has-error' : '' }}">
            <label for="host">{{trans('install.purchase_code')}}</label>
            <input type="text" class="form-control input-sm" id="purchase_code" name="purchase_code" value="{{ old('purchase_code') }}">
        </div>
        <div class="form-group {{ $errors->has('envato_username') ? 'has-error' : '' }}">
            <label for="envato_username">{{trans('install.envato_username')}}</label>
            <input type="text" class="form-control input-sm" id="envato_username" name="envato_username" value="{{ old('envato_username') }}">
        </div>
        <div class="form-group {{ $errors->has('envato_email') ? 'has-error' : '' }}">
            <label for="envato_email">{{trans('install.envato_email')}}</label>
            <input type="text" class="form-control input-sm" id="envato_email" name="envato_email" value="{{ old('envato_email') }}">
        </div>
        <button class="btn btn-success pull-right">
            {{trans('install.next')}}
            <i class="fa fa-arrow-right"></i>
        </button>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
@stop