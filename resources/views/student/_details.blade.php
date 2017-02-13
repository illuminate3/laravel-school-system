<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('student.first_name')}}</label>

            <div class="controls">
                @if (isset($student)) {{ $student->user->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('student.last_name')}}</label>

            <div class="controls">
                @if (isset($student)) {{ $student->user->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('student.email')}}</label>

            <div class="controls">
                @if (isset($student)) {{ $student->user->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('student.gender')}}</label>

            <div class="controls">
                @if (isset($student)) {{ ($student->user->gender=='1')?trans('student.male'):trans('student.female') }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('student.order')}}</label>

            <div class="controls">
                @if (isset($student)) {{ $student->order }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('student.section')}}</label>

            <div class="controls">
                @if (isset($student->section)) {{ $student->section->title }} @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
            <div class="controls row">
                <div class="col-sm-3">
                    <img src="{{ url($student->user->picture) }}" alt="User Image" class="img-thumbnail">
                </div>
            </div>
        </div>
        @if (isset($student->bed->title))
            <div class="form-group">
                <label class="control-label" for="title">{{trans('student.dormitory')}}</label>

                <div class="controls">
                    {{ isset($student->bed->dormitory_room->dormitory->title)?$student->bed->dormitory_room->dormitory->title:"" }},
                    {{ isset($student->bed->dormitory_room->title)?$student->bed->dormitory_room->title:"" }}, {{ $student->bed->title }}
                </div>
            </div>
        @endif
        @if($student->user->parents->count()>0)
            <div class="form-group">
                <label class="control-label" for="title">{{trans('student.parents')}}</label>
                <div class="controls">
                    <ul>
                        @foreach($student->user->parents as $item)
                            @if(isset($item->parent->full_name))
                                <li>{{ $item->parent->full_name }}</li>
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