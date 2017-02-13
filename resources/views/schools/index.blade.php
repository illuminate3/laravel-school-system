@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        @if ((($user->inRole('super_admin') && !$user->inRole('admin')) ||
        ($user->inRole('admin') && $user->inRole('super_admin'))) && Settings::get('multi_school')=='yes')
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('table.title') }}</th>
            <th>{{ trans('schools.address') }}</th>
            <th>{{ trans('schools.phone') }}</th>
            <th>{{ trans('schools.email') }}</th>
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