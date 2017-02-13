<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('staff_salary.full_name')}}</label>
            <div class="controls">
                @if (isset($staffSalary)) {{ $staffSalary->user->full_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('staff_salary.school')}}</label>
            <div class="controls">
                @if (isset($staffSalary)) {{ $staffSalary->school->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('staff_salary.price')}}</label>
            <div class="controls">
                @if (isset($staffSalary)) {{ $staffSalary->price }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('staff_salary.join_start_date')}}</label>
            <div class="controls">
                @if (isset($staffSalary)) {{ $staffSalary->date_start }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('staff_salary.join_end_date')}}</label>
            <div class="controls">
                @if (isset($staffSalary)) {{ $staffSalary->date_end }} @endif
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