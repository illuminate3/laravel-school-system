<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3> SMS {{trans('install.install')}}</h3>
        <ul class="nav side-menu">
            <li class="{{ isset($steps['welcome']) ? $steps['welcome'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-home"></i>
                        <span class="stepDesc text-small">{{trans('install.welcome')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['requirements']) ? $steps['requirements'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-list"></i>
                        <span class="stepDesc text-small">{{trans('install.system_requirements')}}</span></div>
                </a>
            </li>
            <li class="{{ isset($steps['permissions']) ? $steps['permissions'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-lock"></i>
                        <span class="stepDesc text-small">{{trans('install.permissions')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['verify']) ? $steps['verify'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-list"></i>
                        <span class="stepDesc text-small">{{trans('install.validation')}}</span></div>
                </a>
            </li>
            <li class="{{ isset($steps['database']) ? $steps['database'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-database"></i>
                        <span class="stepDesc text-small">{{trans('install.database_info')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['installation']) ? $steps['installation'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-terminal"></i>
                        <span class="stepDesc text-small">{{trans('install.installation')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['settings']) ? $steps['settings'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-wrench"></i>
                        <span class="stepDesc text-small">{{trans('install.settings')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['mail_settings']) ? $steps['mail_settings'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-envelope"></i>
                        <span class="stepDesc text-small">{{trans('install.mail_settings')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['complete']) ? $steps['complete'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-flag-checkered"></i>
                        <span class="stepDesc text-small">{{trans('install.complete')}}</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>