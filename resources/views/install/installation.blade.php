@extends('layouts.install')
@section('content')
    {!! Form::open(['url' => 'install/install']) !!}
    <div class="step-content" style="padding-left: 15px; padding-top: 15px; padding-right: 15px">
        <h3>{{trans('install.installation')}}</h3>
        <hr>
        <p>{{trans('install.ready_to_install')}}</p>
        <p>{{trans('install.be_patient')}}</p>
        <button class="btn btn-success pull-right" data-toggle="loader" data-loading-text="Installing" type="submit">
            <i class="fa fa-play" style="padding-right: 5px"></i>
            {{trans('install.install')}}
        </button>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
@stop