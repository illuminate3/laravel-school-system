@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<div id="payments"></div>
	<div class=" clearfix">
        @if(!Sentinel::getUser()->inRole('admin') ||
		(Sentinel::getUser()->inRole('admin') && Settings::get('multi_school') == 'no') ||
		(Sentinel::getUser()->inRole('admin') && $user->authorized($type.'.create')))
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
	</div>
	<table id="data" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>{{ trans('table.title') }}</th>
				<th>{{ trans('payment.payment_method') }}</th>
				<th>{{ trans('payment.student_full_name') }}</th>
				<th>{{ trans('payment.amount') }}</th>
				<th>{{ trans('payment.status') }}</th>
                <th>{{ trans('table.actions') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script>
        var chart = c3.generate({
            bindto: '#payments',
            data: {
                columns: [
                        @foreach($payments as $item)
                    ['{{$item['title']}}', {{$item['items']}}],
                    @endforeach
                ],
                type: 'pie',
                colors: {
                    @foreach($payments as $item)
                    '{{$item['title']}}': '{{$item['color']}}',
                    @endforeach
                },
                labels: true
            },
            pie: {
                label: {
                    format: function (value, ratio, id) {
                        return d3.format('')(value);
                    }
                }
            }
        });
    </script>
@stop