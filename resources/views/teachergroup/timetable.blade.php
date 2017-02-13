@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if(isset($studentGroup))
        {{trans('teachergroup.timetable_info')}}
        {!! Form::label('students', $studentGroup->title, array('class' => 'control-label')) !!}
    @endif
    <div class="row">
        <div class="col-sm-10">
            <div class="box-body">
                <table class="table table-bordered no-padding">
                    <tbody>
                    <tr>
                        <th>#</th>
                        <th width="14%">{{trans('teachergroup.monday')}}</th>
                        <th width="14%">{{trans('teachergroup.tuesday')}}</th>
                        <th width="14%">{{trans('teachergroup.wednesday')}}</th>
                        <th width="14%">{{trans('teachergroup.thursday')}}</th>
                        <th width="14%">{{trans('teachergroup.friday')}}</th>
                        <th width="14%">{{trans('teachergroup.saturday')}}</th>
                        <th width="14%">{{trans('teachergroup.sunday')}}</th>
                    </tr>
                    @for($i=1;$i<8;$i++)
                        <tr>
                            <td>{{$i}}</td>
                            @for($j=1;$j<8;$j++)
                                <td id="{{$j}}-{{$i}}" class="droppable timetable_table">
                                    @foreach($timetable as $item)
                                        @if($item['week_day']==$j && $item['hour']==$i)
                                            <div class="btn btn-default">
                                                <span>{{$item['title']}}</span>
                                                <br>
                                                <span>{{$item['name']}}</span>
                                                <a id="{{$item['id']}}" class="trash"><i
                                                            class="fa fa-trash-o btn btn-danger btn-xs"></i></a></div>
                                        @endif
                                    @endforeach
                                </td>
                            @endfor
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-2">
            <ul class="list-group">
                @foreach($subject_list as $item)
                    <li class="list-group-item timetable">
                        <div class="draggable" id="{{$item['id']}}">
                            <span>{{$item['title']}}</span>
                            <br>
                            <span>{{$item['name']}}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @if(isset($studentGroup))
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-warning">{{trans('table.back')}}</a>
                <a href="{{ url($type).'/print_timetable' }}" target="_blank"
                   class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> {{trans('table.print')}}</a>
            </div>
        </div>
    @else
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type).'/print_timetable' }}" target="_blank"
                   class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> {{trans('table.print')}}</a>
            </div>
        </div>
    @endif
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $(function () {
                $(".draggable").draggable({
                    cursor: "move",
                    helper: "clone",
                    revert: "invalid"
                });
                $(".droppable").droppable({
                    accept: '.draggable',
                    hoverClass: "ui-state-hover",
                    drop: function (event, ui) {
                        var draggable = parseInt(ui.draggable.attr("id"));
                        var droppable_contener = $(this);
                        var droppable = $(this).attr('id').split('-');
                        $.ajax({
                            type: "POST",
                            url: '{{ url('/teachergroup/addtimetable') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                teacher_subject_id: draggable,
                                week_day: parseInt(droppable[0]),
                                hour: parseInt(droppable[1])
                            },
                            success: function (response) {
                                var div_html = $('div[id="' + draggable + '"]').clone().removeClass('draggable droppable ui-droppable').html();
                                droppable_contener.append('<div class="btn btn-success">' + div_html + '<a class="trash" id="' + response + '"><i class="fa fa-trash-o btn btn-danger btn-xs"></i></a></div>');
                                $('a.trash').click(function () {
                                    var trash = $(this);
                                    $.ajax({
                                        type: "DELETE",
                                        url: '{{ url('/teachergroup/deletetimetable') }}',
                                        data: {_token: '{{ csrf_token() }}', id: trash.attr("id")},
                                        success: function () {
                                            trash.parent().remove();
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
                $('a.trash').click(function () {
                    var trash = $(this);
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/teachergroup/deletetimetable') }}',
                        data: {_token: '{{ csrf_token() }}', id: trash.attr("id")},
                        success: function () {
                            trash.parent().remove();
                        }
                    });
                });
            });
        });
    </script>
@endsection

