@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')

    <student-import url="{{ url('student') }}/"></student-import>

@stop

{{-- Scripts --}}
@section('scripts')

@stop