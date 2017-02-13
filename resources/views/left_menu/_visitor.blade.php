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
        <h3>{{ trans('left_menu.visitor') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'visitor_card') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor_card/'.$user->id)}}" target="_blank">
                    <i class="menu-icon fa fa-credit-card text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.visitor_card') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>