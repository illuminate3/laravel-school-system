<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('custom_user_field.role')}}</label>
            <div class="controls">
                @if (isset($customUserField->role))
                    {{ $customUserField->role->name }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('custom_user_field.title')}}</label>
            <div class="controls">
                @if (isset($customUserField))
                    {{ $customUserField->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('custom_user_field.type')}}</label>
            <div class="controls">
                @if (isset($customUserField))
                    {{ $customUserField->type }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('custom_user_field.options')}}</label>
            <div class="controls">
                @if (isset($customUserField))
                    {{ $customUserField->options }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('custom_user_field.is_required')}}</label>
            <div class="controls">
                @if (isset($customUserField))
                    {{ @($customUserField->is_required==0)?trans('custom_user_field.no'):trans('custom_user_field.yes') }}
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