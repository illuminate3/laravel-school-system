<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3> SMS {{trans('update.update')}}</h3>
        <ul class="nav side-menu">
            <li class="{{ isset($steps['welcome']) ? $steps['welcome'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-home"></i>
                        <span class="stepDesc text-small">{{trans('update.welcome')}}</span>
                    </div>
                </a>
            </li>
            <li class="{{ isset($steps['complete']) ? $steps['complete'] : '' }}">
                <a>
                    <div class="stepNumber"><i class="fa fa-flag-checkered"></i>
                        <span class="stepDesc text-small">{{trans('update.complete')}}</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
