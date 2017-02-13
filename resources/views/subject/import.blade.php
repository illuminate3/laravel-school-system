@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')

    <subject-import url="{{ url('subject') }}/"></subject-import>

@stop

{{-- Scripts --}}
@section('scripts')

@stop