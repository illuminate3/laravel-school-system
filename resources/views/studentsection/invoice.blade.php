@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('table.title') }}</th>
            <th>{{ trans('invoice.description') }}</th>
            <th>{{ trans('invoice.amount') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if($invoices->count()>0)
            @foreach($invoices as $invoice)
                <tr>
                    <td>{!! $invoice['title'] !!}</td>
                    <td>{!! $invoice['description'] !!}</td>
                    <td>{!! $invoice['amount'] !!}</td>
                    <td><a class="btn btn-success" href="{{url('/payment/'.$invoice['id'].'/pay')}}">
                            <i class="fa fa-shopping-cart"></i> {{ trans('invoice.pay_online') }}</a>
                        <a target="_blank" class="btn btn-info" href="{{url('/studentsection/invoice/'.$invoice['id'].'/show')}}">
                            <i class="fa fa-print"></i> {{ trans('invoice.print') }}</a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop