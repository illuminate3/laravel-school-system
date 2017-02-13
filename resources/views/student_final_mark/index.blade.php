@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    <div class="form-group required {{ $errors->has('section_select') ? 'has-error' : '' }}">
        {!! Form::label('section_select',trans('student_final_mark.select_section'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('section_select', $sections, null, array('id'=>'section_select', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('section_select', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('group_select') ? 'has-error' : '' }}">
        {!! Form::label('group_select',trans('student_final_mark.group_select'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('group_select', array(), null, array('id'=>'group_select', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('group_select', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('group_select') ? 'has-error' : '' }}">
        {!! Form::label('subject_select',trans('student_final_mark.subject_select'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('subject_select', array(), null, array('id'=>'subject_select', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('subject_select', ':message') }}</span>
        </div>
    </div>
    {!! Form::label('change_save',trans('student_final_mark.change_save'), array('class' => 'control-label')) !!}
    <div id="students">

    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#section_select").change(function() {
                $('#students').empty();

                var $select = $('#subject_select');
                $select.find('option').remove();

                var $select = $('#group_select');
                $select.find('option').remove();

                if ($(this).val() != "") {
                    $.ajax({
                        type: "GET",
                        url: '{{url('/student_final_mark/')}}/' + $(this).val() + '/get-groups',
                        success: function (response) {
                            $select.append('<option value="">{{trans('student_final_mark.group_select')}}</option>');
                            $.each(response, function (key, val) {
                                $select.append('<option value=' + key + '>' + val + '</option>');
                            })
                        }
                    });
                }
            });
        });

        $("#group_select").change(function() {

            $('#students').empty();

            var $select = $('#subject_select');
            $select.find('option').remove();

            if ($(this).val() != "") {
                $.ajax({
                    type: "GET",
                    url: '{{url('/student_final_mark/')}}/' + $(this).val() + '/get-subjects',
                    success: function (response) {
                        $select.append('<option value="">{{trans('student_final_mark.subject_select')}}</option>');
                        $.each(response, function (key, val) {
                            $select.append('<option value=' + key + '>' + val + '</option>');
                        })

                    }
                });
            }
        });
        $("#subject_select").change(function() {

            $('#students').empty();

            if ($(this).val() != "") {
                var mark_values_student = '<div class="row"><div class="col-sm-6">{{trans('student_final_mark.student')}}</div>' +
                                            '<div class="col-sm-6">{{trans('student_final_mark.mark')}}</div></div>';
                $.ajax({
                    type: "GET",
                    url: '{{url('/student_final_mark/')}}/' + $("#group_select").val() + '/' + $(this).val() + '/get-students',
                    success: function (response) {
                        $.each(response.student_marks, function (key, val) {
                            mark_values_student += '<div class="row"><div class="col-sm-6"><label class="control-label">' + val.student_name + '</label></div>' +
                                    '<div class="col-sm-6"><select name="mark_value[' + val.student_id + ']" class="form-control" id="mark_value">';
                            $.each(response.mark_values, function (key2, val2) {
                                mark_values_student += '<option ';
                                if (val.mark_value == key2) {
                                    mark_values_student += ' selected="selected"';
                                }
                                mark_values_student += 'value="'+key2+'">'+val2+'</option>';
                            })
                            mark_values_student +='</select></div></div><br>';
                        })
                        $('#students').html(mark_values_student);

                        $("select[name^='mark_value']").change(function() {
                            var mark_value = $(this).val();

                            var select_name = $(this).attr("name");
                            var student = select_name.split('[')[1].split(']')[0];

                            var subject = $("#subject_select").val();

                            $.ajax({
                                type: "POST",
                                url: '{{url('/student_final_mark/add-final-mark')}}',
                                data: {_token: '{{ csrf_token() }}',
                                    mark_value_id: mark_value,
                                    student_id: student,
                                    subject_id: subject},
                                success: function () {

                                }
                            });
                        })
                    }
                });
            }
        });
    </script>
@endsection