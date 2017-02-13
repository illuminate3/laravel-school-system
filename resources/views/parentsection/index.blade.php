@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('parentsection.name') }}</th>
            <th>{{ trans('parentsection.section') }}</th>
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