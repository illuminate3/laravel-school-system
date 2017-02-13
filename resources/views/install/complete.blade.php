@extends('layouts.install')
@section('content')
    <div class="step-content" style="padding-left: 15px; padding-top: 15px">
        <h3>{{trans('install.complete2')}}</h3>
        <hr>
        <p><strong>{{trans('install.well_done')}}</strong></p>
        <p>{{trans('install.successfully')}}</p>

        @if (is_writable(base_path()))
            <p>{!!trans('install.final_info')!!}</p>
        @endif
        <a class="btn btn-success pull-right" href="{{ url('/') }}">
            <i class="fa fa-sign-in"></i>
            {{trans('install.login')}}
        </a>
        <div class="clearfix"></div>
    </div>
@stop