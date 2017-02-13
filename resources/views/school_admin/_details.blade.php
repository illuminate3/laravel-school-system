<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('school_admin.first_name')}}</label>
            <div class="controls">
                @if (isset($school_admin)) {{ $school_admin->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('school_admin.last_name')}}</label>
            <div class="controls">
                @if (isset($school_admin)) {{ $school_admin->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('school_admin.email')}}</label>
            <div class="controls">
                @if (isset($school_admin)) {{ $school_admin->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('school_admin.gender')}}</label>
            <div class="controls">
                @if (isset($school_admin)) {{ ($school_admin->gender=='1')?trans('school_admin.male'):trans('school_admin.female') }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('school_admin.school')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->school->title }} @endif
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
        @foreach(array_chunk($permission_groups ,4) as $row)
            <div class="row">
                @foreach($row as $key => $group)
                    <div class="col-md-3">
                        <p><strong>{{$group['group_name']}}</strong></p>
                        <div class="input-group">
                            @foreach($permissions as $permission)
                                @if($permission['group_name'] == $group['group_name'])
                                    <label>
                                        <input type="checkbox" disabled name="permissions[]" value="{{$group['group_slug'].'.'.str_slug($permission['name'])}}"
                                               class='icheck'
                                               @if(isset($school_admin) &&
                                                    $school_admin->authorized($group['group_slug'].'.'.str_slug($permission['name']))) checked @endif>
                                        {{ucfirst(title_case(str_replace('_', ' ',$permission['name'])))}}
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

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

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@stop
