<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teachergroup.name')}}</label>

            <div class="controls">
                @if (isset($studentGroup)) {{ $studentGroup->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teachergroup.class')}}</label>

            <div class="controls">
                @if (isset($studentGroup)) {{ $studentGroup->class }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teachergroup.direction')}}</label>

            <div class="controls">
                @if (isset($studentGroup->direction->title)) {{ $studentGroup->direction->title }} @endif
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