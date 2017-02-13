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
        </div>
    </div>
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('book.internal') }}</th>
            <th>{{ trans('table.title') }}</th>
            <th>{{ trans('book.author') }}</th>
            <th>{{ trans('book.year') }}</th>
            <th>{{ trans('book.quantity') }}</th>
            <th>{{ trans('book.remain') }}</th>
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