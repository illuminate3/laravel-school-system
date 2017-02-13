@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="row">
            {!! Form::open(array('url' => url($type.'/'.$schoolYear->id.'/post_data'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}

            <div class="form-group {{ $errors->has('select_school_year_id') ? 'has-error' : '' }}">
                {!! Form::label('select_school_year_id', trans('schoolyear.schoolyear_select_info'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('select_school_year_id', $school_year_list, null, array('id'=>'select_school_year_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('select_school_year_id', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('select_school_id') ? 'has-error' : '' }}">
                {!! Form::label('select_school_year_id', trans('schoolyear.select_school'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('select_school_id', $school_list, null, array('id'=>'select_school_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('select_school_id', ':message') }}</span>
                </div>
            </div>
            <h4><label class="label label-info">{{trans('schoolyear.type_new_names').$schoolYear->title}}</label></h4>
            <h4><label class="label label-danger">{{trans('schoolyear.type_new_names_continue').$schoolYear->title}}</label></h4>
            <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}" xmlns="http://www.w3.org/1999/html">
                {!! Form::label('section_id', trans('schoolyear.section'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::select('section_id', [], null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
                </div>
            </div>
            <div id="sections">

            </div>
            <br>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
	</div>
</div>
@stop

@section('scripts')
	<script>
        $( document ).ready(function() {
            $("#select_school_year_id, #select_school_id").change(function() {
                $('#sections').html('');
                $('#section_id').find('option').remove().end();
                var select_school_id = $('#select_school_id').val();
                var select_school_year_id = $('#select_school_year_id').val();
                if (select_school_id != "" && select_school_year_id != "") {
                    $.ajax({
                        type: "GET",
                        url: '{{url('/schoolyear')}}/' + select_school_year_id + '/' + select_school_id + '/get_sections',
                        success: function (response) {
                            $('#section_id').append($('<option></option>').val(0).html('{{trans('schoolyear.section_select')}}'));
                            $.each(response, function (val, text) {
                                $('#section_id').append($('<option></option>').val(val).html(text));
                            });
                            $("#section_id").change(function() {
                                $('#sections').html('');
                                var section_id = $('#section_id').val();
                                if (section_id != "" && section_id != "0") {
                                    var sections = '<label class="control-label">{{trans('schoolyear.section_name')}}</label>' +
                                        '<input type="text" id="section_name" name="section_name" class="form-control">' +
                                        '<label class="control-label">{{trans('schoolyear.select_students')}}</label>' +
                                        '<select class="form-control select2" multiple="multiple" id="students_list" name="students_list[]">' +
                                        '<input type="checkbox" id="select_all_students" >{{trans('schoolyear.select_all_students')}}';
                                    $('#sections').append(sections);
                                    $.ajax({
                                        type: "GET",
                                        url: '{{url('/schoolyear')}}/' + section_id + '/get_students',
                                        success: function (response) {
                                            $.each(response, function (key, val) {
                                                $('#students_list').append($('<option></option>').val(key).html(val)).select2();
                                            });
                                        }
                                    });
                                    $("#select_all_students").click(function(){
                                        if($("#select_all_students").is(':checked') ){
                                            $("#students_list > option").prop("selected","selected");
                                            $("#students_list").trigger("change");
                                        }else{
                                            $("#students_list > option").removeAttr("selected");
                                            $("#students_list").trigger("change");
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        })
	</script>
@endsection