@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		<div class="pull-right">
			<a href="{{ url($type.'/'.$teacher->id.'/create') }}" class="btn btn-sm btn-primary">
				<i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
		</div>
	</div>
	<input type="hidden" id="id" value="{{$teacher->id}}">
	<table id="data" class="table table-bordered table-hover" data-id="data">
		<thead>
			<tr>
				<th>{{ trans('join_date.full_name') }}</th>
				<th>{{ trans('join_date.school') }}</th>
				<th>{{ trans('join_date.join_start_date') }}</th>
				<th>{{ trans('join_date.join_end_date') }}</th>
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