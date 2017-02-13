@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		@if($user->authorized($type.'.create'))
			<div class="pull-right">
				<a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
					<i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
				<a href="{{ url($type.'/import') }}" class="btn btn-sm btn-success">
					<i class="fa fa-upload"></i> {{trans('student.import_student')}}
				</a>
			</div>
		@endif
	</div>
	<table id="data" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>{{ trans('student.section') }}</th>
				<th>{{ trans('student.full_name') }}</th>
				<th>{{ trans('student.order') }}</th>
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