@extends('layouts.install')
@section('content')
    <div class="step-content">
        <h3>{{trans('install.welcome')}}</h3>
        <hr>
        <p>{{trans('install.steps_guide')}}</p>
        <p>{{trans('install.installation_process')}} </p>
        <br>
        <a href="{{ url('install/requirements') }}">
            <button class="btn btn-success pull-right" type="button">
                {{trans('install.next')}}
                <i class="fa fa-arrow-right" style="margin-left: 6px"></i>
            </button>
        </a>
        <div class="clearfix"></div>
    </div>
@stop