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
				<th>{{ trans('table.title') }}</th>
				<th>{{ trans('payment.payment_method') }}</th>
				<th>{{ trans('payment.amount') }}</th>
				<th>{{ trans('payment.status') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop