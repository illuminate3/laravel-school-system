@extends('layouts.frontend')
@section('content')
    <h1>{!! trans('frontend.faq') !!}</h1>
    <p>{!! trans('frontend.faq_info') !!}</p>
    <div class="row">
        <div class="col-md-12">
            @if (isset($faq_categories) && !empty($faq_categories))
                <div class="panel-group" id="accordion">
                @foreach($faq_categories as $key => $faq_grp)
                    <h3>{{$faq_grp->title}}</h3>
                        @foreach($faqs as $faq)
                            @if($faq_grp->id == $faq->faq_category_id)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">{{$key+1}}.
                                            <a data-toggle="collapse" data-parent="#accordion" href="#faq{{$faq->id}}">
                                                {{$faq->title}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="faq{{$faq->id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {{$faq->content}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                @endforeach
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-body">{{trans('frontend.no_results')}}</div>
                </div>
            @endif
        </div>
    </div>
@stop
