@extends('layouts.install')
@section('content')
    @if (! $allGranted)
        <div class="alert alert-danger">
            {!!trans('install.system_not_meet_requirements')!!}
        </div>
    @endif
    <div class="step-content">
        <h3>{{trans('install.permissions')}}</h3>
        <hr>
        <ul class="list-group list_req">
            @foreach($folders as $path => $isWritable)
                <li class="list-group-item">
                    {{ $path }}
                    @if ($isWritable)
                        <span class="label label-default pull-right">775</span>
                        <span class="badge badge1"><i class="fa fa-check"></i></span>
                    @else
                        <span class="label label-default pull-right">775</span>
                        <span class="badge badge2"><i class="fa fa-times"></i></span>
                    @endif
                </li>
            @endforeach
        </ul>
        @if ($allGranted)
            <a class="btn btn-success pull-right" href="{{ url('install/verify') }}">
                {{trans('install.next')}}
                <i class="fa fa-arrow-right"></i>
            </a>
        @else
            <a class="btn btn-info pull-right" href="{{ url('install/permissions') }}">
                {{trans('install.refresh')}}
                <i class="fa fa-refresh"></i></a>
            <button class="btn btn-success pull-right" disabled>
                {{trans('install.next')}}
                <i class="fa fa-arrow-right"></i>
            </button>
        @endif
        <div class="clearfix"></div>
    </div>
@stop