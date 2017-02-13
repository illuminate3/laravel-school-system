@extends('layouts.secure')
@section('content')
<div class="col-sm-4 col-md-2">
    <a class="thumbnail">
        <img src="{{ url($user->picture) }}" class="img-rounded" alt="User Image">
    </a>
</div>
<div class="col-sm-7 col-md-9 col-sm-offset-1">
    <div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td><b>{{trans('profile.first_name')}}</b></td>
                <td><a href="#" > {{$user->first_name}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.last_name')}}</b></td>
                <td><a href="#" > {{$user->last_name}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.gender')}}</b></td>
                <td><a href="#" >@if($user->gender==0) {{trans('profile.male')}} @else {{trans('profile.female')}} @endif </a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.email')}}</b></td>
                <td><a href="#">{{$user->email}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.mobile')}}</b></td>
                <td><a href="#"> {{$user->mobile}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.phone')}}</b></td>
                <td><a href="#"> {{$user->phone}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.address')}}</b></td>
                <td><a href="#">{{$user->address}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.birth_date')}}</b></td>
                <td><a href="#">{{$user->birth_date}}</a></td>
            </tr>
            <tr>
                <td><b>{{trans('profile.birth_city')}}</b></td>
                <td><a href="#">{{$user->birth_city}}</a></td>
            </tr>
        </tbody>
    </table>
        <a href="{{url('/account')}}" class="btn btn-success">
            <i class="fa fa-pencil-square-o"></i> {{trans('profile.change_profile')}}</a>
    </div>
</div>

@stop