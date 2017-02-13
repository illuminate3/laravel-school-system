@extends('layouts.install')
@section('content')
    <div class="step-content" style="padding-left: 15px; padding-top: 15px">
        <h3>{{trans('install.whoops')}}</h3>
        <hr>
        <p><strong>{!! trans('install.something_wrong')!!}</strong></p>
        <p>{!! trans('install.check_log') !!}</p>
        <a class="btn btn-warning pull-right" href="{{ url('install') }}">
            <i class="fa fa-undo"></i>
            {{trans('install.try_again')}}
        </a>
        <div class="clearfix"></div>
    </div>
@stop