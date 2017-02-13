@extends('layouts.frontend')
@section('content')
    <h1>{!! $title !!}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="details">
                {!! $introduction !!}
                @foreach($schools as $school)
                    <div class="row">
                        <h3> {{ $school->title }} </h3>
                        <div class="col-md-5">
                            <img src="{{ url($school->photo) }}" class="img-thumbnail">
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label" for="address">{{trans('schools.address')}}</label>
                                <div class="controls">
                                    {{ $school->address }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="phone">{{trans('schools.phone')}}</label>
                                <div class="controls">
                                    {{ $school->phone }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">{{trans('schools.email')}}</label>
                                <div class="controls">
                                    {{ $school->email }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="controls">
                                    {{ $school->about }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop