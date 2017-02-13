<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.title')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.student')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->student->user->first_name }} {{ $applyingLeave->student->user->last_name }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.parent')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->parent->first_name }} {{ $applyingLeave->parent->last_name }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.date')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->date }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.description')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->description }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.created')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->created_at }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applyingleave.updated')}}</label>

            <div class="controls">
                @if (isset($applyingLeave))
                    {{ $applyingLeave->updated_at }}
                @endif
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