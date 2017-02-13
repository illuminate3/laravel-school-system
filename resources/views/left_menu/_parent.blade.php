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
        <h3>{{ trans('left_menu.parent') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'studentsection/timetable')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/timetable')}}">
                    <i class="menu-icon fa fa-calendar text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.timetable') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'bookuser/index')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/bookuser/index')}}">
                    <i class="menu-icon fa fa-book text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'borrowedbook/index')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/borrowedbook/index')}}">
                    <i class="menu-icon fa fa-list text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.borrowed_books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'applyingleave')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/applyingleave')}}">
                    <i class="menu-icon fa fa-external-link text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.applying_leave') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'notice')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.session('current_student_user_id').'/notice')}}">
                    <i class="menu-icon fa fa-paper-plane text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.notice') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'attendances')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.session('current_student_user_id').'/attendances')}}">
                    <i class="menu-icon fa fa-exchange text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.attendances') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'marks')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.session('current_student_user_id').'/marks')}}">
                    <i class="menu-icon fa fa-list-ol text-primary"></i>
                    <span class="mm-text">{{ trans('left_menu.marks') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'exams')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.session('current_student_user_id').'/exams')}}">
                    <i class="menu-icon fa fa-file-excel-o text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.exams') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'subjectboo') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.session('current_student_user_id').'/subjectbook')}}">
                    <i class="menu-icon fa fa-list-alt text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.subjectbook') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'diary')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/diary')}}">
                    <i class="menu-icon fa fa-comment text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.diary') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'study_material') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/study_material')}}">
                    <i class="menu-icon fa fa-magic text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.study_material') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'studentsection/payment')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/payment')}}">
                    <i class="menu-icon fa fa-money text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.payments') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'studentsection/invoice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/invoice')}}">
                    <i class="menu-icon fa fa-credit-card text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.invoice') }}</span>
                </a>
            </li>
            @if(isset($transportations) && $transportations>0)
                <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'transportparent')  ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/transportparent')}}">
                        <i class="menu-icon fa fa-compass text-primary"></i>
                        <span class="mm-text">{{ trans('left_menu.transportation') }}</span>
                    </a>
                </li>
            @endif
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'forstudent')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.session('current_student_user_id').'/forstudent')}}">
                    <i class="menu-icon fa fa-flag-checkered text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.reports') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>