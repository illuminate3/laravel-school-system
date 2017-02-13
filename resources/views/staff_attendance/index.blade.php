@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('staff_attendance.attendances_title')}}
    <div class="row">
        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item disabled">
                    {{trans('staff_attendance.select_staff')}}
                </li>
                @foreach($users as $key =>$item)
                    <li id="{{$key}}" class="list-group-item">{{$item}}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    {!! Form::label('date', trans('staff_attendance.date'), array('class' => 'control-label')) !!}
                    <div class="control"  style="position: relative">
                    {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    {!! Form::label('option_id', trans('staff_attendance.attendance_type'), array('class' => 'control-label')) !!}
                    {!! Form::select('option_id', $options, null, array('id'=>'option_id', 'class' => 'form-control select2')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    {!! Form::label('comment', trans('staff_attendance.comment'), array('class' => 'control-label')) !!}
                    {!! Form::textarea('comment', null, array('id'=>'comment', 'class' => 'form-control','size' => '30x5')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <button type="button"
                            class="btn btn-success add_attendance">{{trans('staff_attendance.add_attendance')}}</button>
                </div>
            </div>
            <br>

            <div id="attendances">
                <table class="table table-bordered">
                    <thead>
                    <th class="col-sm-5">{{trans('staff_attendance.staff')}}</th>
                    <th class="col-sm-4">{{trans('staff_attendance.attendance_type')}}</th>
                    <th class="col-sm-3">{{trans('staff_attendance.delete')}}</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $('.list-group-item').not(".disabled").click(function () {
            $(this).toggleClass('active');
        });

        $('#date').change(function () {
            var date = $(this).val();
            if (date != "") {
                getattendance();
            }
        });
        $('.add_attendance').click(function () {
            var date = $('#date').val();
            var comment = $('#comment').val();
            var option_id = $('#option_id').val();
            var users = $.makeArray($('.list-group-item.active').map(function (index) {
                return this.id;
            }));
            $.ajax({
                type: "POST",
                url: '{{ url('/staff_attendance/add') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    date: date,
                    comment: comment,
                    option_id: option_id,
                    users: users
                },
                success: function () {
                    $('.list-group-item').removeClass('active');
                    getattendance();
                }
            })
        });
        function getattendance() {
            var date = $('#date').val();
            $('#attendances tbody').empty();
            $.ajax({
                type: "POST",
                url: '{{ url('/staff_attendance/attendance') }}',
                data: {_token: '{{ csrf_token() }}', date: date},
                success: function (result) {
                    data = $.parseJSON(result);
                    $.each(data, function (i, item) {
                        $('#attendances tbody').append('<tr><td>' + item.name + '</td><td>' + item.option + '</td><td><span class="btn btn-danger delete_attendance" id="' + item.id + '"><i class="fa fa-trash-o"></i></span></td></tr>');
                    });
                    //justified_attendance();
                }
            })
        }
        /*

         function justified_attendance() {
         $('.delete_attendance').click(function () {
         var $attendance = $(this);
         var attendance_id = $attendance.attr('id');
         $.ajax({
         type: "POST",
         url: '{{ url('/attendance/delete') }}',
         data: {_token: '{{ csrf_token() }}', id: attendance_id},
         success: function (result) {
         $attendance.parent().parent().remove();
         }
         })
         })

         $('.no_justify').click(function () {
         var $attendance = $(this);
         var attendance_id = $attendance.attr('id');
         $.ajax({
         type: "POST",
         url: '{{ url('/attendance/justified') }}',
         data: {_token: '{{ csrf_token() }}', id: attendance_id, justified:'no'},
         success: function () {
         }
         })
         getattendance();
         })
         $('.justify').click(function () {
         var $attendance = $(this);
         var attendance_id = $attendance.attr('id');
         $.ajax({
         type: "POST",
         url: '{{ url('/attendance/justified') }}',
         data: {_token: '{{ csrf_token() }}', id: attendance_id, justified:'yes'},
         success: function () {
         }
         })
         getattendance();
         })
         }*/
    </script>
@endsection

