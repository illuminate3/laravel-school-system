<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('parent.first_name')}}</label>

            <div class="controls">
                @if (isset($parentStudent)) {{ $parentStudent->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('parent.last_name')}}</label>

            <div class="controls">
                @if (isset($parentStudent)) {{ $parentStudent->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('parent.email')}}</label>

            <div class="controls">
                @if (isset($parentStudent)) {{ $parentStudent->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('parent.gender')}}</label>

            <div class="controls">
                @if (isset($parentStudent)) {{ ($parentStudent->gender=='1')?trans('parent.male'):trans('parent.female') }} @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
            <div class="controls row">
                <div class="col-sm-3">
                    <img src="{{ url($parentStudent->picture) }}" alt="User Image" class="img-thumbnail">
                </div>
            </div>
        </div>
        @if($students->count()>0)
            <div class="form-group">
                <label class="control-label" for="title">{{trans('parent.students')}}</label>
                <div class="controls">
                    <ul>
                        @foreach($students as $item)
                            @if(isset($item->full_name))
                                <li>{{ $item->full_name }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
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