<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="school">{{trans('desktop_application.school')}}</label>

            <div class="controls">
                @if (isset($desktopApplication->school->title)) {{ $desktopApplication->school->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="auth_id">{{trans('desktop_application.auth_id')}}</label>

            <div class="controls">
                @if (isset($desktopApplication)) {{ $desktopApplication->auth_id }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="auth_secure">{{trans('desktop_application.auth_secure')}}</label>

            <div class="controls">
                @if (isset($desktopApplication)) {{ $desktopApplication->auth_secure }} @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>