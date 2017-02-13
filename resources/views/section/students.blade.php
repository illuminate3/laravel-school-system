@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<input type="hidden" id="id" value="{{$id}}">
	<table id="data" class="table table-bordered table-hover" data-id="studentsdata">
		<thead>
			<tr>
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