@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="details">
				@include($type.'/_details')
			</div>
		</div>
	</div>
@stop