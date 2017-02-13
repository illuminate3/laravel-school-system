<div class="profile">
    <div class="profile_pic">
        <img src="{{ url($user->picture) }}" alt="User Image" class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>{{ $user->full_name }}</span>
    </div>
    @if(session('wp_user'))
        <a href="{{url('back_to_wp')}}">{{trans('left_menu.back_to_wp')}}</a>
    @endif
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.librarian') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'book') &&
            !starts_with(Route::getCurrentRoute()->getPath(), 'booklibrarian')? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/book')}}">
                    <i class="menu-icon fa fa-book text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'booklibrarian') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/booklibrarian')}}">
                    <i class="menu-icon fa fa-list text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.issue_books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'reservedbook') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/reservedbook')}}">
                    <i class="menu-icon fa fa-list-ol text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.reserved_books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'task') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/task')}}">
                    <i class="menu-icon fa fa-thumb-tack text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.task') }}</span>
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