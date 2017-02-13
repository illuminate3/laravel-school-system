@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('certificate.users_info')}}
    {!! Form::label('students', $certificate->title, array('class' => 'control-label')) !!}
    {!! Form::model($certificate, array('url' => url($type) . '/' . $certificate->id.'/addusers', 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
    <div class="form-group">
        <div class="controls">
            {!! Form::select('users_select[]', $users, $users_select, array('id'=>'users_select', 'multiple'=>true, 'class' => 'form-control select2')) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url('/certificate') }}"
               class="btn btn-warning">{{trans('table.back')}}</a>
            <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
    </script>
@endsection
