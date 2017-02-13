@extends('layouts.update')
@section('content')
    <div class="step-content">
        <h3>{{trans('update.welcome')}}</h3>
        <hr>
        <p>{{trans('update.steps_guide')}}</p>
        <p>{{trans('update.update_process')}} </p>
        <br>
        {!! Form::open(['url' => 'update/'.$version.'/start-update']) !!}
            <button class="btn btn-success pull-right" type="submit">
                {{trans('update.begin_update')}}
                <i class="fa fa-arrow-right" style="margin-left: 6px"></i>
            </button>
        {!! Form::close() !!}
        <div class="clearfix"></div>
    </div>
@stop