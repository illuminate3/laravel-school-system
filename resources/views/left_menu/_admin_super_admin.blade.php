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
        <h3>{{ trans('left_menu.super_admin') }}</h3>
        <ul class="nav side-menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-primary"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li class="{!! (starts_with(Route::getCurrentRoute()->getPath(), 'schoolyear')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'semester')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'direction')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'subject')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'marktype')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'markvalue')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'noticetype')
                    || starts_with(Route::getCurrentRoute()->getPath(), 'behavior')? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-pencil text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.global_for_schools') }}</span>
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'schoolyear') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/schoolyear')}}">
                            <i class="menu-icon fa fa-briefcase text-warning"></i>
                            <span class="mm-text">{{ trans('left_menu.school_years') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'semester') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/semester')}}">
                            <i class="menu-icon fa fa-list text-danger"></i>
                            <span class="mm-text">{{ trans('left_menu.semesters') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'direction') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/direction')}}">
                            <i class="menu-icon fa fa-arrows-alt text-success"></i>
                            <span class="mm-text">{{ trans('left_menu.directions') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'school_direction') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/school_direction')}}">
                            <i class="menu-icon fa fa-arrows-h text-danger"></i>
                            <span class="mm-text">{{ trans('left_menu.school_direction') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'marksystem') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/marksystem')}}">
                            <i class="menu-icon fa fa-adjust text-primary"></i>
                            <span class="mm-text">{{ trans('left_menu.mark_system') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'subject') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/subject')}}">
                            <i class="menu-icon fa fa-list text-info"></i>
                            <span class="mm-text">{{ trans('left_menu.subjects') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'marktype') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/marktype')}}">
                            <i class="menu-icon fa fa-list-ul text-warning"></i>
                            <span class="mm-text">{{ trans('left_menu.mark_type') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'markvalue') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/markvalue')}}">
                            <i class="menu-icon fa fa-list-ol text-success"></i>
                            <span class="mm-text">{{ trans('left_menu.mark_value') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'noticetype') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/noticetype')}}">
                            <i class="menu-icon fa fa-list-alt text-info"></i>
                            <span class="mm-text">{{ trans('left_menu.notice_type') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'behavior') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/behavior')}}">
                            <i class="menu-icon fa fa-indent text-warning"></i>
                            <span class="mm-text">{{ trans('left_menu.behavior') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'schools') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/schools')}}">
                    <i class="menu-icon fa fa-server text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.schools') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'school_admin') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/school_admin')}}">
                    <i class="menu-icon fa fa-user-md text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.school_admin') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'login_history') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/login_history')}}">
                    <i class="menu-icon fa fa-sign-in text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.login_history') }}</span>
                </a>
            </li>
            <li {!! ((starts_with(Route::getCurrentRoute()->getPath(), 'notice') && !starts_with(Route::getCurrentRoute()->getPath(), 'noticetype'))? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/notice')}}">
                    <i class="menu-icon fa fa-paper-plane text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.notice') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'diary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/diary')}}">
                    <i class="menu-icon fa fa-comment text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.diary') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'section') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/section')}}">
                    <i class="menu-icon fa fa-graduation-cap text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.sections') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'student') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student')}}">
                    <i class="menu-icon fa fa-users text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.students') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'student_final_mark') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student_final_mark')}}">
                    <i class="menu-icon fa fa-list-ol text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.student_final_mark') }}</span>
                </a>
            </li>
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
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'parent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/parent')}}">
                    <i class="menu-icon fa fa-user-md text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.parents') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'human_resource') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/human_resource')}}">
                    <i class="menu-icon fa fa-user-md text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.human_resource') }}</span>
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
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'visitors') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor')}}">
                    <i class="menu-icon fa fa-user text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.visitors') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'scholarship') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/scholarship')}}">
                    <i class="menu-icon fa fa-gift text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.scholarship') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'salary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/salary')}}">
                    <i class="menu-icon fa fa-credit-card text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.salary') }}</span>
                </a>
            </li>
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
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'slider') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/slider')}}">
                    <i class="menu-icon fa fa-sliders text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.slider') }}</span>
                </a>
            </li>
            @if(Settings::get('sms_driver')!="" && Settings::get('sms_driver') !='none')
                <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'sms_message') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/sms_message')}}">
                        <i class="menu-icon fa fa-envelope text-warning"></i>
                        <span class="mm-text">{{ trans('left_menu.sms_message') }}</span>
                    </a>
                </li>
            @endif
            <li class="{!! (starts_with(Route::getCurrentRoute()->getPath(), 'dormitory') ? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-bed text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.dormitories') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="nav child_menu">
                    <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'dormitory')  ? 'class="active"' : '') !!}>
                        <a href="{{url('/dormitory')}}">
                            <i class="menu-icon fa fa-list text-warning"></i>
                            <span class="mm-text">{{ trans('left_menu.dormitories') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'dormitoryroom') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/dormitoryroom')}}">
                            <i class="menu-icon fa fa-list-ol text-danger"></i>
                            <span class="mm-text">{{ trans('left_menu.dormitory_rooms') }}</span>
                        </a>
                    </li>
                    <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'dormitorybed')  ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/dormitorybed')}}">
                            <i class="menu-icon fa  fa-bed text-success"></i>
                            <span class="mm-text">{{ trans('left_menu.dormitory_beds') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li {!! (ends_with(Route::getCurrentRoute()->getPath(), 'transportation') ? 'class="active"' : '') !!}>
                <a href="{{url('/transportation')}}">
                    <i class="menu-icon fa fa-compass text-primary"></i>
                    <span class="mm-text">{{ trans('left_menu.transportation') }}</span>
                </a>
            </li>
            <li class="{!! (starts_with(Route::getCurrentRoute()->getPath(), 'invoice')
                        || starts_with(Route::getCurrentRoute()->getPath(), 'debtor')
                        || starts_with(Route::getCurrentRoute()->getPath(), 'payment') ? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-list text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.payment') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="nav child_menu">
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
                </ul>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'pages') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/pages')}}">
                    <i class="menu-icon fa fa-pagelines text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.page') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'certificate') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/certificate')}}">
                    <i class="menu-icon fa fa-certificate text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.certificate') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'holiday') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/holiday')}}">
                    <i class="menu-icon fa fa-calendar-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.holiday') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'blog_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/blog_category')}}">
                    <i class="menu-icon fa fa-barcode text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.blog_categories') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'blog') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/blog')}}">
                    <i class="menu-icon fa fa-bars text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.blog') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'custom_user_field') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/custom_user_field')}}">
                    <i class="menu-icon fa fa-th-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.custom_user_field') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'faq_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/faq_category')}}">
                    <i class="menu-icon fa fa-question-circle text-warning"></i>
                    <span class="mm-text">{{ trans('left_menu.faq_category') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'faq') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/faq')}}">
                    <i class="menu-icon fa fa-question text-info"></i>
                    <span class="mm-text">{{ trans('left_menu.faq') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'option') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/option')}}">
                    <i class="menu-icon fa fa-cog text-danger"></i>
                    <span class="mm-text">{{ trans('left_menu.option') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::getCurrentRoute()->getPath(), 'setting') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/setting')}}">
                    <i class="menu-icon fa fa-cogs text-success"></i>
                    <span class="mm-text">{{ trans('left_menu.settings') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>