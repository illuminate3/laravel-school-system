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
        <h3>{{ trans('left_menu.accountant') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'invoice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/invoice')}}">
                    <i class="menu-icon fa fa-credit-card text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.invoice') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'debtor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/debtor')}}">
                    <i class="menu-icon fa fa-money text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.debtor') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'payment') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/payment')}}">
                    <i class="menu-icon fa fa-money text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.payment') }}</span>
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
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'return_book_penalty') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/return_book_penalty')}}">
                    <i class="menu-icon fa fa-bookmark text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.return_book_penalty') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>