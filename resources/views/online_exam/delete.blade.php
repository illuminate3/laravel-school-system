@extends('layouts.secure')

@section('title')
    {{ $title }}
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('url' => url($type) . '/' . $onlineExam->id, 'method' => 'delete', 'class' => 'bf')) !!}
            @include($type.'/_details')
            {!! Form::close() !!}
        </div>
    </div>
@stop
@section('scripts')
    <script>
    </script>
@endsection