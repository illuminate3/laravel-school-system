<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <title> {{$title or 'SMS'}} | {{ Settings::get('name') }}</title>
    @if(Settings::get('rtl_support') == 'yes')
        <link href="{{ asset('css/rtl_login.css') }}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css"/>
    @endif
    <link href="{{ asset('css/custom_colors.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body class="login-page" id="bg-img">
@include('flash::message')
@yield('content')
<script src="{{ asset('/js/login.js') }}"></script>
</body>
</html>