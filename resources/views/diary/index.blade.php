@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if(Sentinel::inRole('teacher'))
        <div class=" clearfix">
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        </div>
    @endif
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('table.title') }}</th>
            <th>{{ trans('diary.subject') }}</th>
            <th>{{ trans('diary.hour') }}</th>
            <th>{{ trans('diary.date') }}</th>
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