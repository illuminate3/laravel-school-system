@extends('layouts.secure')
{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type.'/attendance'), 'target'=>'_blank',  'method' => 'post')) !!}
    <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}" xmlns="http://www.w3.org/1999/html">
        {!! Form::label('section_id', trans('student_attendances_admin.section'), array('class' => 'control-label required')) !!}
        <div class="controls">
            {!! Form::select('section_id', $sections, null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
        {!! Form::label('start_date', trans('student_attendances_admin.start_date'), array('class' => 'control-label required')) !!}
        <div class="controls" style="position: relative">
            {!! Form::text('start_date', null, array('class' => 'form-control date','id'=>'start_date')) !!}
            <span class="help-block">{{ $errors->first('start_date', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
        {!! Form::label('end_date', trans('student_attendances_admin.end_date'), array('class' => 'control-label required')) !!}
        <div class="controls" style="position: relative">
            {!! Form::text('end_date', null, array('class' => 'form-control date','id'=>'end_date')) !!}
            <span class="help-block">{{ $errors->first('end_date', ':message') }}</span>
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            <button type="submit" class="btn btn-success">{{trans('student_attendances_admin.generate_pdf')}}</button>
            <button type="button" class="btn btn-success show_attendances">{{trans('student_attendances_admin.show_results')}}</button>

        </div>
    </div>
    {!! Form::close() !!}
    <div class="row attendances">

    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.attendances').hide();
            $('.show_attendances').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var section_id = $('#section_id option:selected').val();
                if (start_date.length > 0 && end_date.length > 0 && section_id.length > 0) {
                    $('.attendances').html('').show();
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/student_attendances_admin/attendanceAjax') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            start_date: start_date,
                            end_date: end_date,
                            section_id: section_id
                        },
                        success: function (result) {
                            $('.attendances').html(result);
                        }
                    })
                }
            });
        });
    </script>
@stop

