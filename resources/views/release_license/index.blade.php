@extends('layouts.verify')
@section('content')
    {!! Form::open(array('url' =>  'release_license', 'method' => 'post')) !!}
    <div class="step-content" style="padding-left: 15px; padding-top: 15px; padding-right: 15px">
        <h3>{{trans('release_license.release_license_info')}}</h3>
        <hr>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url('/') }}" class="btn btn-warning">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
@stop