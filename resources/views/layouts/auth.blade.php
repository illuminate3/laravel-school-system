<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._meta')
    @include('layouts._assets')
</head>
<body>
<div class="app" id="app">
    <div class="login animated fadeIn">
        <div class="navbar">
            <a class="navbar-brand text-center" style="float:none;">
                <img src="{{ url('uploads/site').'/thumb_'.Settings::get('logo') }}"
                     alt="{{ Settings::get('name') }}" class="img-circle"
                     style="margin:auto;width:60px;height:60px;">
            </a>
        </div>
        @include('flash::message')
        @yield('content')
    </div>
</div>
@include('layouts._assets_footer')
</body>
</html>
