@extends('layouts.secure')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.calendar')}}</h1>
            <div id="calendar"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.books')}}</h1>
            <div id="books"></div>
            <div id="book_categories"></div>
        </div>
    </div>
@stop
@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script src="{{ asset('js/countUp.min.js') }}" type="text/javascript"></script>
    <script>
        var chart = c3.generate({
            bindto: '#books',
            data: {
                columns: [
                    @foreach($books as $item)
                        ['{{$item['title']}}', {{$item['items']}}],
                    @endforeach
                ],
                type: 'donut',
                colors: {
                    @foreach($books as $item)
                            '{{$item['title']}}': '{{$item['color']}}',
                    @endforeach
                },
                labels: true
            },
            pie: {
                label: {
                    format: function (value, ratio, id) {
                        return d3.format('')(value);
                    }
                }
            }
        });

        var chart_book_categories = c3.generate({
            bindto: '#book_categories',
            data: {
                columns: [
                        @foreach($book_categories as $item)
                    ['{{$item['value']}}', {{$item['books']}}],
                    @endforeach
                ],
                type: 'donut',
                colors: {
                    @foreach($book_categories as $item)
                    '{{$item['value']}}': '{{$item['color']}}',
                    @endforeach
                },
                labels: true
            },
            pie: {
                label: {
                    format: function (value, ratio, id) {
                        return d3.format('')(value);
                    }
                }
            }
        });
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                "header": {
                    "left": "prev,next today",
                    "center": "title",
                    "right": "month,agendaWeek,agendaDay"
                },
                "eventLimit": true,
                "firstDay": 1,
                "eventRender": function (event, element) {
                    element.popover({
                        content: event.description,
                        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        title: event.title,
                        container: 'body',
                        trigger: 'click',
                        placement: 'auto'
                    });
                },
                "eventSources": [
                    {
                        url: "{{url('events')}}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        error: function () {
                            alert('there was an error while fetching events!');
                        }
                    }
                ]
            });
        });
    </script>
@stop
