@extends('layouts.secure')
@section('content')
    <div class="row">
        @if($certificates->count()>0)
            @foreach($certificates as $item)
                <div class="col-sm-6">
                    <b>{!! $item->title !!}</b>
                    <img width="300" class="img-thumbnail"
                         src="{{ url(isset($item->image)?'/uploads/certificate/'.$item->image:"") }}">
                </div>
            @endforeach
        @endif
    </div>
    <hr>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url('/') }}" class="btn btn-primary">{{trans('table.back')}}</a>
        </div>
    </div>
@stop