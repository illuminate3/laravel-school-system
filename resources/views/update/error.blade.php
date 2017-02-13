@extends('layouts.update')
@section('content')
    <div class="step-content" style="padding-left: 15px; padding-top: 15px">
        <h3>{{trans('update.whoops')}}</h3>
        <hr>
        <p><strong>{!! trans('update.something_wrong')!!}</strong></p>
        <p>{!! trans('update.check_log') !!}</p>
        <a class="btn btn-warning pull-right" href="{{ url('update/'.$version) }}">
            <i class="fa fa-undo"></i>
            {{trans('update.try_again')}}
        </a>
        <div class="clearfix"></div>
    </div>
@stop