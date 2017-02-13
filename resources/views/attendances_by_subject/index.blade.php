@extends('layouts.secure')
{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/attendance'), 'target'=>'_blank',  'method' => 'post')) !!}
    <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}" xmlns="http://www.w3.org/1999/html">
        {!! Form::label('section_id', trans('attendances_by_subject.section'), array('class' => 'control-label required')) !!}
        <div class="controls">
            {!! Form::select('section_id', $sections, null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('group_id') ? 'has-error' : '' }}" xmlns="http://www.w3.org/1999/html">
        {!! Form::label('group_id', trans('attendances_by_subject.group'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('group_id', [], null, array('id'=>'group_id', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('group_id', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('student_id') ? 'has-error' : '' }}" xmlns="http://www.w3.org/1999/html">
        {!! Form::label('group_id', trans('attendances_by_subject.student'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('student_id', [], null, array('id'=>'student_id', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('student_id', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
        {!! Form::label('start_date', trans('attendances_by_subject.start_date'), array('class' => 'control-label required')) !!}
        <div class="controls" style="position: relative">
            {!! Form::text('start_date', null, array('class' => 'form-control date','id'=>'start_date')) !!}
            <span class="help-block">{{ $errors->first('start_date', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
        {!! Form::label('end_date', trans('attendances_by_subject.end_date'), array('class' => 'control-label required')) !!}
        <div class="controls" style="position: relative">
            {!! Form::text('end_date', null, array('class' => 'form-control date','id'=>'end_date')) !!}
            <span class="help-block">{{ $errors->first('end_date', ':message') }}</span>
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            <button type="button" class="btn btn-success show_attendances">{{trans('student_attendances_admin.show_results')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="row attendances">

    </div>
@stop
@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#section_id').change(function () {
                var section_id = $(this).val();
                $('#group_id').empty();
                $('#student_id').empty();
                if (section_id > 0) {
                    $('#group_id').append($('<option></option>').val(0).html('{{trans('attendances_by_subject.select_group')}}'));
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/attendances_by_subject/get_groups') }}',
                        data: {_token: '{{ csrf_token() }}', section_id: section_id},
                        success: function (result) {
                            $.each(result, function (val, text) {
                                $('#group_id').append($('<option></option>').val(val).html(text))
                            });
                        }
                    });
                }
            });
            $('#group_id').change(function () {
                var group_id = $(this).val();
                $('#student_id').empty();
                if (group_id > 0) {
                    $('#student_id').append($('<option></option>').val(0).html('{{trans('attendances_by_subject.select_student')}}'));
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/attendances_by_subject/get_students') }}',
                        data: {_token: '{{ csrf_token() }}', group_id: group_id},
                        success: function (result) {
                            $.each(result, function (val, text) {
                                $('#student_id').append($('<option></option>').val(val).html(text))
                            });
                        }
                    });
                }
            });

            $('.attendances').hide();
            $('.show_attendances').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var section_id = $('#section_id option:selected').val();
                var group_id = $('#group_id option:selected').val();
                var student_id = $('#student_id option:selected').val();
                if (start_date.length > 0 && end_date.length > 0 && section_id.length > 0) {
                    $('.attendances').html('').show();
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/attendances_by_subject/attendance_graph') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            start_date: start_date,
                            end_date: end_date,
                            section_id: section_id,
                            group_id: group_id,
                            student_id: student_id
                        },
                        success: function (result) {
                            $.each(result.attendance_types , function (index, value){
                                var attendances_by_subject = [];
                                $.each(result.attendance_graph[index], function (k,v){
                                    attendances_by_subject.push(['"'+v+'"', k]);
                                });
                                console.log(attendances_by_subject);

                                $('.attendances').append('<h3>' + value + '</h3><br><div id="attendance_'+index+'"></div>');
                                var chart = c3.generate({
                                    bindto: '#attendance_'+index,
                                    data: {
                                        columns: attendances_by_subject,
                                        type: 'bar'
                                    },
                                    bar: {
                                        width: {
                                            ratio: 0.5
                                        }
                                    }
                                });
                            });
                        }
                    })
                }
            });
        });
    </script>
@stop

