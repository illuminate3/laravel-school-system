@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('studentgroup.timetable_info')}}
    {!! Form::label('students', $studentGroup->title, array('class' => 'control-label')) !!}
    <div class="row">
        <div class="col-sm-10">
            <div class="box-body">
                <table class="table table-bordered no-padding">
                    <tbody>
                    <tr>
                        <th>#</th>
                        <th width="14%">{{trans('studentgroup.monday')}}</th>
                        <th width="14%">{{trans('studentgroup.tuesday')}}</th>
                        <th width="14%">{{trans('studentgroup.wednesday')}}</th>
                        <th width="14%">{{trans('studentgroup.thursday')}}</th>
                        <th width="14%">{{trans('studentgroup.friday')}}</th>
                        <th width="14%">{{trans('studentgroup.saturday')}}</th>
                        <th width="14%">{{trans('studentgroup.sunday')}}</th>
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
    <div class="form-group">
        <div class="controls">
            <a href="{{ url('/section/'.$section->id.'/groups') }}"
               class="btn btn-warning">{{trans('table.back')}}</a>
            <a href="{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/print_timetable') }}" target="_blank"
               class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> {{trans('table.print')}}</a>
        </div>
    </div>
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
                            url: '{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/addtimetable') }}',
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
                                        url: '{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/deletetimetable') }}',
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
                        url: '{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/deletetimetable') }}',
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

