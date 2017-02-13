@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('teachergroup.students_info')}}
    {!! Form::label('students', $studentGroup->title, array('class' => 'control-label')) !!}
    {!! Form::model($studentGroup, array('url' => url($type).'/'.$studentGroup->id.'/addstudents', 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
    <div class="form-group">
        <div class="controls">
            {!! Form::select('students_select[]', $students, $students_added, array('id'=>'students_select', 'multiple'=>true, 'class' => 'form-control select2')) !!}
            <input type="checkbox" id="select_all_students" >{{trans('teachergroup.select_all_students')}}
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url($type) }}"
               class="btn btn-warning">{{trans('table.back')}}</a>
            <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $("#select_all_students").click(function(){
            if($("#select_all_students").is(':checked') ){
                $("#students_select > option").prop("selected","selected");
                $("#students_select").trigger("change");
            }else{
                $("#students_select > option").removeAttr("selected");
                $("#students_select").trigger("change");
            }
        });
    </script>
@endsection

