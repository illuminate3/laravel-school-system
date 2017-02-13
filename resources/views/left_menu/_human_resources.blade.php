<div class="profile">
    <div class="profile_pic">
        <img src="{{ url($user->picture) }}" alt="User Image" class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>{{ $user->full_name }}</span>
    </div>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.human_resources') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'parent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/parent')}}">
                    <i class="menu-icon fa fa-user-md text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.parents') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'teacher') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teacher')}}">
                    <i class="menu-icon fa fa-user-secret text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.teachers') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'librarian') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/librarian')}}">
                    <i class="menu-icon fa fa-user text-primary"></i>
                    <span class="mm-text">{{ trans('left_menu.librarians') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'accountant') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/accountant')}}">
                    <i class="menu-icon fa fa-tty text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.accountants') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'staff_attendance') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/staff_attendance')}}">
                    <i class="menu-icon fa fa-taxi text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.staff_attendance') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'salary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/salary')}}">
                    <i class="menu-icon fa fa-credit-card text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.salary') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>