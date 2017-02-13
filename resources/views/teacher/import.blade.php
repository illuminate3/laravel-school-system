@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')

    <teacher-import url="{{ url('teacher') }}/"></teacher-import>

@stop

{{-- Scripts --}}
@section('scripts')

@stop