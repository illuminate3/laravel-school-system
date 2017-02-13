@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="livicon" data-name="inbox" data-size="18" data-color="white" data-hc="white"
                       data-l="true"></i>
                    {{trans('task.my_tasks')}}
                </h4>
            </div>
            <div class="panel-body">
                <div class="row list_of_items">
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script src="{{ asset('js/todolist_admin.js') }}"></script>
@stop