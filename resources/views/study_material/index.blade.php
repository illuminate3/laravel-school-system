@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if($user->inRole('teacher'))
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
            <th>{{ trans('study_material.title') }}</th>
            <th>{{ trans('study_material.subject') }}</th>
            <th>{{ trans('study_material.student_group') }}</th>
            <th>{{ trans('study_material.date_off') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function () {
            @if(isset($subject))
                oTable.ajax.url('{!! url($type.'/data/'.$subject->id) !!}');
                oTable.ajax.reload();
            @endif
        });
    </script>
@stop