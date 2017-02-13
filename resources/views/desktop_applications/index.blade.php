@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		<div class="pull-right">
			<a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
				<i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
		</div>
	</div>
	<table id="data" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>{{ trans('desktop_application.school') }}</th>
				<th>{{ trans('desktop_application.auth_id') }}</th>
				<th>{{ trans('desktop_application.auth_secure') }}</th>
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