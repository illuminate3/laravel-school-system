@extends('layouts.secure')
@section('content')
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td>
                <b>{!! Form::label('first_name', trans('profile.first_name'), array('class' => 'control-label')) !!}</b>
            </td>
            <td><a href="#"> {{$user->first_name}}</a></td>
        </tr>
        <tr>
            <td>
                <b>{!! Form::label('last_name', trans('profile.last_name'), array('class' => 'control-label')) !!}</b>
            </td>
            <td><a href="#"> {{$user->last_name}}</a></td>
        </tr>
        <tr>
            <td><b>{!! Form::label('gender', trans('profile.gender'), array('class' => 'control-label')) !!}</b>
            </td>
            <td>
                <a href="#">@if($user->gender==0) {{trans('profile.male')}} @else {{trans('profile.female')}}  @endif </a>
            </td>
        </tr>
        <tr>
            <td>
                <b>{!! Form::label('birth_date', trans('profile.birth_date'), array('class' => 'control-label')) !!}</b>
            </td>
            <td><a href="#">{{$user->birth_date}}</a></td>
        </tr>
        <tr>
            <td><b>{!! Form::label('email', trans('profile.email'), array('class' => 'control-label')) !!}</b></td>
            <td><a href="#">{{$user->email}}</a></td>
        </tr>
        </tbody>
    </table>
    {!! Form::model($user, array('url' => url('account'), 'method' => 'post', 'files'=> true)) !!}
    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
        {!! Form::label('phone', trans('profile.phone'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::text('phone', null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('mobile') ? 'has-error' : '' }}">
        {!! Form::label('mobile', trans('profile.mobile'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::text('mobile', null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
            <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
        {!! Form::label('address', trans('profile.address'), array('class' => 'control-label required')) !!}
        <div class="controls">
            {!! Form::text('address', null, array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('birth_city') ? 'has-error' : '' }}">
        {!! Form::label('birth_city', trans('profile.birth_city'), array('class' => 'control-label required')) !!}
        <div class="controls">
            {!! Form::text('birth_city', null, array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
        {!! Form::label('password', trans('profile.password'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::password('password', array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('password', ':message') }}</span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('automatic_sms_mark', trans('profile.get_sms'), array('class' => 'control-label')) !!}
        <div class="controls">
            <div class="form-inline">
                <div class="radio">
                    {!! Form::radio('get_sms', 1,($user->get_sms==1)?true:false)  !!}
                    {!! Form::label(1, trans('profile.yes'))  !!}
                </div>
                <div class="radio">
                    {!! Form::radio('get_sms', 0, ($user->get_sms==0)?true:false)  !!}
                    {!! Form::label(0, trans('profile.no')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('about') ? 'has-error' : '' }}">
        {!! Form::label('about', trans('profile.about'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::textarea('about', null, array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('about', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('user_avatar_file') ? 'has-error' : '' }}">
        {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
        <div class="controls row" v-image-preview>
            <div class="col-sm-3">
                <img src="{{ url($user->picture) }}" alt="User Image" class="img-thumbnail">
            </div>
            <div class="col-sm-4">
                <span class="help-block">{{ $errors->first('user_avatar_file', ':message') }}</span>
            </div>
        </div>
        <div class="row">
            @if(Settings::get('upload_webcam')=='upload')
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                         style="width: 200px; height: 150px;">
                        <img id="image-preview" width="300" class="img-thumbnail">
                    </div>
                    <div>
                        <span class="btn btn-default btn-file"><span
                                    class="fileinput-new">{{trans('auth.select_image')}}</span>
                            <span class="fileinput-exists">{{trans('auth.change')}}</span>
                            <input type="file" name="user_avatar_file"></span>
                        <a href="#" class="btn btn-default fileinput-exists"
                           data-dismiss="fileinput">{{trans('auth.remove')}}</a>
                    </div>
                </div>
            @else
                <div class="col-sm-6">
                    <video id="video" width="400" height="300"></video>
                    <a href="#" class="btn btn-primary" id="capture"
                       style="margin-top: 1%;">{{trans('auth.snapshot')}}</a>
                </div>
                <div class="col-sm-6" id="avatar">
                    <canvas id="canvas" width="400" height="300"></canvas>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url('/') }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
            <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('scripts')
    @if(Settings::get('upload_webcam')=='webcam')
        <script>
            (function () {
                var video = document.getElementById('video');
                var canvas = document.getElementById('canvas');
                var context = canvas.getContext('2d');
                var photo = document.getElementById('photo_url');
                var vendorUrl = window.URL || window.webkitURL;

                navigator.getMedia = navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia ||
                        navigator.msGetUserMedia;

                navigator.getMedia({
                    video: true,
                    audio: false
                }, function (stream) {
                    video.src = vendorUrl.createObjectURL(stream);
                    video.play();
                }, function (error) {
                    //Doslo je do greske
                    //error.code
                });

                document.getElementById('capture').addEventListener('click', function () {
                    context.drawImage(video, 0, 0, 400, 300);
                    $('#photo').remove();
                    $('#photo_url').remove();
                    var data_uri = canvas.toDataURL('image/png');
                    $('#avatar').append('<input type="hidden" id="photo_url" name="photo_url" value="' + data_uri + '"/>');
                })
            })();
            $('form:first').submit(function () {
                $.ajax({
                    type: "POST",
                    url: '{{url('webcam')}}',
                    data: $('form').serialize(),
                    success: function (data) {
                        window.location.replace('profile');
                    }
                });
                return false;
            })
        </script>
    @endif
@stop