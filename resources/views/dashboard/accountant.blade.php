@extends('layouts.secure')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.salary_by_month')}}</h1>
            <div id="salary_by_month"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.payments_by_month')}}</h1>
            <div id="payments_by_month"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.calendar')}}</h1>
            <div id="calendar"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.students_section_per_year')}}</h1>
            <div id="students_section_per_year"></div>
        </div>
    </div>

@stop
@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script>
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
        $(function () {
            var salary_by_month = [
                ['{{trans('dashboard.salary_by_month')}}'],
                    @foreach($per_month as $item)
                [{{$item['salary_by_month']}}],
                @endforeach
            ];
            var salary = c3.generate({
                bindto: '#salary_by_month',
                data: {
                    rows: salary_by_month,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#FD9883']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($per_month as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                salary.resize();
            }, 2000);

            setTimeout(function () {
                salary.resize();
            }, 4000);

            setTimeout(function () {
                salary.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                salary.resize();
            });

        });

        $(function () {
            var payments_by_month = [
                ['{{trans('dashboard.sum_of_payments')}}', '{{trans('dashboard.sum_of_invoices')}}'],
                    @foreach($per_month as $item)
                [{{$item['sum_of_payments']}}, {{$item['sum_of_invoices']}}],
                @endforeach
            ];
            var payments = c3.generate({
                bindto: '#payments_by_month',
                data: {
                    rows: payments_by_month,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#4fc1e9', '#a0d468']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($per_month as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                payments.resize();
            }, 2000);

            setTimeout(function () {
                payments.resize();
            }, 4000);

            setTimeout(function () {
                payments.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                payments.resize();
            });

        });

        $(function () {
            var students_section_per_year = [
                ['{{trans('dashboard.students')}}', '{{trans('dashboard.section')}}'],
                    @foreach($per_school_year as $item)
                [{{$item['number_of_students']}},{{$item['number_of_sections']}}],
                @endforeach
            ];
            var students_section = c3.generate({
                bindto: '#students_section_per_year',
                data: {
                    rows: students_section_per_year,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#a0d468', '#4fc1e9']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatSchoolYear(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatSchoolYear(d) {

                @foreach($per_school_year as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['school_year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                students_section.resize();
            }, 2000);

            setTimeout(function () {
                students_section.resize();
            }, 4000);

            setTimeout(function () {
                students_section.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                students_section.resize();
            });

        });
    </script>
@stop
