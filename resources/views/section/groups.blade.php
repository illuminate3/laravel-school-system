@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		@if($user->authorized('student_group.create'))
		<div class="pull-right">
			<a href="{{ url('/studentgroup/'.$id.'/create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
		</div>
		@endif
	</div>
	<input type="hidden" id="id" value="{{$id}}">
	<table id="data" class="table table-bordered table-hover" data-id="groupsdata">
		<thead>
			<tr>
				<th>{{ trans('studentgroup.name') }}</th>
				<th>{{ trans('studentgroup.direction') }}</th>
                <th>{{ trans('studentgroup.class') }}</th>
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