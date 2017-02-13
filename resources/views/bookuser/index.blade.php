@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<table id="data" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>{{ trans('bookuser.title') }}</th>
				<th>{{ trans('bookuser.author') }}</th>
				<th>{{ trans('bookuser.subject') }}</th>
				<th>{{ trans('table.actions') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop