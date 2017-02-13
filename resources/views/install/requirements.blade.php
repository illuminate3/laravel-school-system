@extends('layouts.install')
@section('content')
    @if (! $allLoaded)
        <div class="alert alert-danger">
            {!!trans('install.system_not_meet_requirements')!!}
        </div>
    @endif
    <div class="step-content">
        <h3>{{trans('install.system_requirements')}}</h3>
        <hr>
        <ul class="list-group list_req">
            @foreach ($requirements as $extension => $loaded)
                <li class="list-group-item {{ ! $loaded ? 'list-group-item-danger' : '' }}">
                    {{ $extension }}
                    @if ($loaded)
                        <span class="badge badge1"><i class="fa fa-check"></i></span>
                    @else
                        <span class="badge badge2"><i class="fa fa-times"></i></span>
                    @endif
                </li>
            @endforeach
        </ul>
        @if ($allLoaded)
            <a class="btn btn-success pull-right" href="{{ url('install/permissions') }}">
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