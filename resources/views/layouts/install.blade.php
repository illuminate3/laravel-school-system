<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <title>{{trans('install.installation')}} | SMS</title>
    @include('layouts._assets_install')
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/install.css') }}">
</head>
<!--[if lt IE 10]>
<p class="browsehappy">{{trans('dashboard.outdated_browser')}}<a href="http://browsehappy.com/">{{trans('dashboard.new_one')}}</a>.</p>
<![endif]-->
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="float:none; border: 0;">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ url('uploads/site/sms.png') }}" alt="logo"
                             style="width:40px;height:40px;"/>
                        SMS
                    </a>
                </div>
                @include('/install.steps')
            </div>
        </div>
        <div class="right_col" role="main">
            @include('layouts.messages')
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/libs.js') }}" type="text/javascript"></script>

@yield('scripts')
</body>
</html>
