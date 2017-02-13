@extends('layouts.frontend')
@section('content')
    @foreach($blogs as $item)
        <h2><a href="{{url('blogitem/'.$item->slug)}}">{!! $item->title !!}</a></h2>
        <div class="row">
            <div class="col-md-12">
                <div class="details">
                    {!! str_limit($item->content,250) !!}<br>
                    <a href="{{url('blogitem/'.$item->slug)}}">{!! trans('frontend.read_more') !!}</a>
                </div>
            </div>
        </div>
    @endforeach
    {{ $blogs->links() }}
@stop