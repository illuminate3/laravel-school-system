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