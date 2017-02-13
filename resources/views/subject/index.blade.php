@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        <div class="pull-right">
            <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            <a href="{{ url($type.'/import') }}" class="btn btn-sm btn-success">
                <i class="fa fa-upload"></i> {{trans('subject.import_subject')}}
            </a>
        </div>
    </div>
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('subject.order') }}</th>
            <th>{{ trans('subject.class') }}</th>
            <th>{{ trans('markvalue.mark_system') }}</th>
            <th>{{ trans('table.title') }}</th>
            <th>{{ trans('subject.direction') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop