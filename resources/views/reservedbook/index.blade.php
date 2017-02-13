@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">

    </div>
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('reservedbook.user_reserved') }}</th>
            <th>{{ trans('reservedbook.book') }}</th>
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