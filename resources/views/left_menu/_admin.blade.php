<div class="profile">
    <div class="profile_pic">
        <img src="{{ url($user->picture) }}" alt="User Image" class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>{{ $user->full_name }}</span>
    </div>
    @if(session('was_super_admin'))
        <a href="{{url('back_to_admin')}}">{{trans('left_menu.back_to_super_admin')}}</a>
    @endif
    @if(session('wp_user'))
        <a href="{{url('back_to_wp')}}">{{trans('left_menu.back_to_wp')}}</a>
    @endif
</div>
<br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.admin') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'schools') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/schools')}}">
                    <i class="menu-icon fa fa-server text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.schools') }}</span>
                </a>
            </li>
            @if($user->authorized('notice.show'))
            <li {!! ((starts_with(Route::getCurrentRoute()->getPath(), 'notice') && !starts_with(Route::getCurrentRoute()->getPath(), 'noticetype'))? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/notice')}}">
                    <i class="menu-icon fa fa-paper-plane text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.notice') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('diary.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'diary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/diary')}}">
                    <i class="menu-icon fa fa-comment text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.diary') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('section.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'section') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/section')}}">
                    <i class="menu-icon fa fa-graduation-cap text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.sections') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('student.show'))
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'student') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student')}}">
                    <i class="menu-icon fa fa-users text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.students') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('student-final-marks.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'student_final_mark') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student_final_mark')}}">
                    <i class="menu-icon fa fa-list-ol text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.student_final_mark') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('student_attendances_admin.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'student_attendances_admin') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student_attendances_admin')}}">
                    <i class="menu-icon fa fa-list-alt text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.student_attendances_admin') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'attendances_by_subject') ? 'class="active"' : '') !!}>
                <a href="{{url('/attendances_by_subject')}}">
                    <i class="menu-icon fa fa-info text-primary"></i>
                    <span class="mm-text">{{ trans('left_menu.attendances_by_subject') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('parent.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'parent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/parent')}}">
                    <i class="menu-icon fa fa-user-md text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.parents') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('human_resource.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'human_resource') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/human_resource')}}">
                    <i class="menu-icon fa fa-user-md text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.human_resource') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('teacher.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'teacher') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teacher')}}">
                    <i class="menu-icon fa fa-user-secret text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.teachers') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('librarian.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'librarian') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/librarian')}}">
                    <i class="menu-icon fa fa-user text-primary"></i>
                    <span class="mm-text">{{ trans('left_menu.librarians') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('accountant.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'accountant') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/accountant')}}">
                    <i class="menu-icon fa fa-tty text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.accountants') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('visitor.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'visitor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor')}}">
                    <i class="menu-icon fa fa-user text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.visitors') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('scholarship.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'scholarship') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/scholarship')}}">
                    <i class="menu-icon fa fa-gift text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.scholarship') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('salary.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'salary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/salary')}}">
                    <i class="menu-icon fa fa-credit-card text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.salary') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('fee_category.show'))
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'fee_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/fee_category')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.fee_categories') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'task') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/task')}}">
                    <i class="menu-icon fa fa-thumb-tack text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.task') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('sms_message.show'))
                @if(Settings::get('sms_driver')!=""  && Settings::get('sms_driver') !='none')
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'sms_message') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/sms_message')}}">
                            <i class="menu-icon fa fa-envelope text-warning"></i>
                            <span class="mm-text">{{ trans('left_menu.sms_message') }}</span>
                        </a>
                    </li>
                @endif
            @endif
            @if($user->authorized('dormitory.show') ||
            $user->authorized('dormitoryroom.show') ||
            $user->authorized('dormitorybed.show'))
            <li class="{!! (starts_with(Route::getCurrentRoute()->getPath(), 'dormitory') ? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-bed text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.dormitories') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="nav child_menu">
                    @if($user->authorized('dormitory.show'))
                        <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'dormitory')  ? 'class="active"' : '') !!}>
                            <a href="{{url('/dormitory')}}">
                                <i class="menu-icon fa fa-list text-warning"></i>
                                <span class="mm-text">{{ trans('left_menu.dormitories') }}</span>
                            </a>
                        </li>
                    @endif
                    @if($user->authorized('dormitoryroom.show'))
                        <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'dormitoryroom') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/dormitoryroom')}}">
                                <i class="menu-icon fa fa-list-ol text-danger"></i>
                                <span class="mm-text">{{ trans('left_menu.dormitory_rooms') }}</span>
                            </a>
                        </li>
                    @endif
                    @if( $user->authorized('dormitorybed.show'))
                        <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'dormitorybed')  ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/dormitorybed')}}">
                                <i class="menu-icon fa  fa-bed text-success"></i>
                                <span class="mm-text">{{ trans('left_menu.dormitory_beds') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($user->authorized('transportation.show'))
                <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'transportation') ? 'class="active"' : '') !!}>
                    <a href="{{url('/transportation')}}">
                        <i class="menu-icon fa fa-compass text-primary"></i>
                        <span class="mm-text">{{ trans('left_menu.transportation') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('invoice.show') ||
                $user->authorized('debtor.show') ||
                $user->authorized('payments.show'))
            <li class="{!! (starts_with(Route::getCurrentRoute()->getPath(), 'invoice')
                        || starts_with(Route::getCurrentRoute()->getPath(), 'debtor')
                        || starts_with(Route::getCurrentRoute()->getPath(), 'payment') ? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-list text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.payment') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="nav child_menu">
                    @if($user->authorized('invoice.show'))
                        <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'invoice') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/invoice')}}">
                                <i class="menu-icon fa fa-credit-card text-warning"></i>
                                <span class="mm-text">{{ trans('left_menu.invoice') }}</span>
                            </a>
                        </li>
                    @endif
                    @if($user->authorized('debtor.show'))
                        <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'debtor') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/debtor')}}">
                                <i class="menu-icon fa fa-money text-danger"></i>
                                <span class="mm-text">{{ trans('left_menu.debtor') }}</span>
                            </a>
                        </li>
                    @endif
                    @if($user->authorized('payment.show'))
                        <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'payment') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/payment')}}">
                                <i class="menu-icon fa fa-money text-success"></i>
                                <span class="mm-text">{{ trans('left_menu.payment') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($user->authorized('holiday.show'))
                <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'holiday') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/holiday')}}">
                        <i class="menu-icon fa fa-calendar-o text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.holiday') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>