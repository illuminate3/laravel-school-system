<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._meta')
    @include('layouts._assets')
    @yield('styles')
</head>
<body class="nav-md">
<!--[if lt IE 10]>
<p class="browsehappy">{{trans('dashboard.outdated_browser')}}<a href="http://browsehappy.com/">{{trans('dashboard.new_one')}}</a>.</p>
<![endif]-->
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="float:none; border: 0;">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ url('uploads/site').'/thumb_'.Settings::get('logo') }}" alt="logo"/>
                        {{ Settings::get('name') }}
                    </a>
                </div>
                @if ($user->inRole('super_admin') && !$user->inRole('admin'))
                    @include('/left_menu._super_admin')
                @elseif ($user->inRole('admin') && !$user->inRole('super_admin'))
                    @include('/left_menu._admin')
                @elseif ($user->inRole('admin') && $user->inRole('super_admin'))
                    @include('/left_menu._admin_super_admin')
                @elseif ($user->inRole('human_resources'))
                    @include('/left_menu._human_resources')
                @elseif ($user->inRole('accountant'))
                    @include('/left_menu._accountant')
                @elseif ($user->inRole('parent'))
                    @include('/left_menu._parent')
                @elseif ($user->inRole('student'))
                    @include('/left_menu._student')
                @elseif ($user->inRole('teacher'))
                    @include('/left_menu._teacher')
                @elseif ($user->inRole('librarian'))
                    @include('/left_menu._librarian')
                @else
                    @include('/left_menu._visitor')
                @endif
            </div>
        </div>
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        @include("layouts._header-right")
                    </ul>
                </nav>
            </div>
        </div>
        <div class="right_col" role="main">
            <h3>{{ $title or trans('dashboard.welcome') }}</h3>
            @include('flash::message')
            @yield('content')
        </div>
    </div>
    <footer>
        <div class="pull-right">
            @2015 - {{date('Y')}} System Developed By<a class="label label-success" href="http://fb.me/devzohaib">Zohaib Ahmad</a>
        </div>
        <div class="clearfix"></div>
    </footer>
</div>
@include('layouts._assets_footer')
@yield('scripts')
<script>
    $(document).ready(function () {
        $('.date').datetimepicker({
            format: '{{ Settings::get('jquery_date') }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });
        $('.datetime').datetimepicker({
            format: '{{ Settings::get('jquery_date_time') }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });
        $('.date').on('change dp.change', function (e) {
            $('.date').trigger('change');
        })
        $('.datetime').on('change dp.change', function (e) {
            $('.datetime').trigger('change');
        })
    })
</script>
</body>
</html>