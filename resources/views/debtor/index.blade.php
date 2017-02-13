@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div class=" clearfix">
		@if(!Sentinel::getUser()->inRole('admin') ||
		(Sentinel::getUser()->inRole('admin') && Settings::get('multi_school') == 'no') ||
		(Sentinel::getUser()->inRole('admin') && $user->authorized($type.'.create')))
			<div class="pull-right">
				<a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
					<i class="fa fa-plus-circle"></i> {{ trans('debtor.send_sms_email') }}</a>
			</div>
		@endif
	</div>
	<table id="data" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>{{ trans('invoice.full_name') }}</th>
				<th>{{ trans('payment.amount') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop