<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('join_date.full_name')}}</label>
            <div class="controls">
                @if (isset($joinDate)) {{ $joinDate->user->full_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('join_date.school')}}</label>
            <div class="controls">
                @if (isset($joinDate)) {{ $joinDate->school->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('join_date.join_start_date')}}</label>
            <div class="controls">
                @if (isset($joinDate)) {{ $joinDate->date_start }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('join_date.join_end_date')}}</label>
            <div class="controls">
                @if (isset($joinDate)) {{ $joinDate->date_end }} @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type).'/'.$teacher->id }}" class="btn btn-primary">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type).'/'.$teacher->id }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>