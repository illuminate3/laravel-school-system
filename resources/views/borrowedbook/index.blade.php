@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if(Settings::get('late_return_book_make_invoice')=='true')
        <h4>
            <label class="label label-danger">
                {!! trans('borrowedbook.days_limit_give',
                            ['price_by_date_late'=>Settings::get('price_by_date_late')]) !!}
            </label>
        </h4>
    @endif
    <table id="data" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('borrowedbook.title') }}</th>
            <th>{{ trans('borrowedbook.author') }}</th>
            <th>{{ trans('borrowedbook.borrowed') }}</th>
         </tr>
         </thead>
         <tbody>
         </tbody>
     </table>
 @stop
 {{-- Scripts --}}
@section('scripts')

@stop