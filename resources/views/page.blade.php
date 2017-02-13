@extends('layouts.frontend')
@section('content')
    @if(isset($sliders) && $sliders->count()>0 && $page->have_slider == 1)
        <h3>&nbsp</h3>
        <div class="row">
            <div class="col-md-12">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        @foreach($sliders as $key => $item)
                        <div class="item @if($key==0) {{'active'}} @endif">
                            @if($item->url!='')
                                <img src="{!! $item->image !!}"/>
                                <div class="carousel-caption">
                                        <a href="{!! URL::to($item->url) !!}"> <h3>{{$item->title}}</h3></a>
                                    <p>{{$item->content}}</p>
                                </div>
                            @else
                                <img src="{!! $item->image !!}"/>
                                <div class="carousel-caption">
                                    <h3>{{$item->title}}</h3>
                                    <p>{{$item->content}}</p>
                                </div>
                           @endif
                        </div>
                        @endforeach
                    </div>
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="fa fa-angle-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="fa fa-angle-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
    <h1>{!! $page->title !!}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="details">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@stop