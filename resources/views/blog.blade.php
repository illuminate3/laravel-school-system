@extends('layouts.frontend')
@section('content')
    <h1>{!! $blog->title !!}</h1>
    <div class="row">
        <div class="col-md-12">
            <label class="label label-info">{!! $blog->category->title !!}</label>
            <p><span class="glyphicon glyphicon-time"></span> {{trans('frontend.posted_on')}} {!! $blog->created_at->diffForHumans() !!}</p>
            <div class="details">
                @if($blog->image)
                    <image class="image" src="{{ $blog->image }}"></image><br>
                @endif
                {!! $blog->content !!}
            </div>
        </div>
    </div>
@stop