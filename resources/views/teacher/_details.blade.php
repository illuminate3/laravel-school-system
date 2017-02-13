<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher.first_name')}}</label>

            <div class="controls">
                @if (isset($teacher)) {{ $teacher->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher.last_name')}}</label>

            <div class="controls">
                @if (isset($teacher)) {{ $teacher->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher.email')}}</label>

            <div class="controls">
                @if (isset($teacher)) {{ $teacher->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher.gender')}}</label>

            <div class="controls">
                @if (isset($teacher)) {{ ($teacher->gender=='1')?trans('teacher.male'):trans('teacher.female') }} @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
            <div class="controls row">
                <div class="col-sm-3">
                    <img src="{{ url($teacher->picture) }}" alt="User Image" class="img-thumbnail">
                </div>
            </div>
        </div>
        @if(is_array($custom_fields))
            @foreach($custom_fields as $item)
                <div class="form-group">
                    <label class="control-label" for="title">{{ucfirst($item->name)}}</label>
                    <div class="controls">
                        {{ $item->value }}
                    </div>
                </div>
            @endforeach
        @endif
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