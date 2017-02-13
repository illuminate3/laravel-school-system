@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('exam_attendance.attendances_title')}}
    {!! Form::label('exam', $exam->title, array('class' => 'control-label')) !!}
    <div class="row">
        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item disabled">
                    {{trans('attendance.students')}}
                </li>
                @foreach($students as $key =>$item)
                    <li id="{{$key}}" class="list-group-item">{{$item}}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="row">
               <div class="col-sm-4">
                    {!! Form::label('option_id', trans('attendance.attendance_type'), array('class' => 'control-label')) !!}
                    {!! Form::select('option_id', $attendance_type, null, array('id'=>'option_id', 'class' => 'form-control select2')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    {!! Form::label('note', trans('attendance.comment'), array('class' => 'control-label')) !!}
                    {!! Form::textarea('note', null, array('id'=>'note', 'class' => 'form-control','size' => '30x5')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <button type="button" class="btn btn-success add_attendance">{{trans('attendance.add_attendance')}}</button>
                </div>
            </div>
            <br>

            <div id="attendances">
                <table class="table table-bordered">
                    <thead>
                        <th class="col-sm-4">{{trans('attendance.student')}}</th>
                        <th class="col-sm-4">{{trans('attendance.attendance_type')}}</th>
                        <th class="col-sm-2">{{trans('attendance.delete')}}</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $( document ).ready(function() {
            getattendance();
        });
        $('.list-group-item').not(".disabled").click(function () {
            $(this).toggleClass('active');
        });
        $('.add_attendance').click(function () {
            var option_id = $('#option_id option:selected').val();
            var students = $.makeArray($('.list-group-item.active').map(function (index) {
                return this.id;
            }));
            if (students.length > 0) {
                $.ajax({
                    type: "POST",
                    url: '{{ url('/exam_attendance/'.$exam->id.'/add') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        option_id: option_id,
                        exam_id: '{{$exam->id}}',
                        students: students
                    },
                    success: function () {
                        $('.list-group-item').removeClass('active');
                        getattendance();
                    }
                })
            }
        });
        function getattendance() {
            $('#attendances tbody').empty();
            var date = $('#date').val();
            $.ajax({
                type: "POST",
                url: '{{ url('/exam_attendance/'.$exam->id.'/attendance') }}',
                data: {_token: '{{ csrf_token() }}', exam_id: '{{$exam->id}}'},
                success: function (result) {
                    data = $.parseJSON(result);
                    $.each(data, function (i, item) {
                        $('#attendances tbody').append('<tr><td>' + item.name + '</td><td>' + item.option + '</td><td><span class="btn btn-danger delete_attendance" id="' + item.id + '"><i class="fa fa-trash-o"></i></span></td></tr>');
                    });
                    delete_attendance();
                }
            })
        }
        function delete_attendance() {
            $('.delete_attendance').click(function () {
                var $attendance = $(this);
                var attendance_id = $attendance.attr('id');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/exam_attendance/'.$exam->id.'/delete') }}',
                    data: {_token: '{{ csrf_token() }}', id: attendance_id},
                    success: function (result) {
                        $attendance.parent().parent().remove();
                    }
                })
            })
        }
    </script>
@endsection

