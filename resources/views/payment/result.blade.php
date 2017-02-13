@extends('layouts.site')

@section('content')
   <h1>{!! $title !!}</h1>
   <p>{{ $paypalResponse }}</p>
@endsection