<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($school_admin))
            {!! Form::model($school_admin, array('url' => url($type) . '/' . $school_admin->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('school_admin.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('school_admin.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('school_admin.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('school_admin.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('address', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('school_admin.mobile'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mobile', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            {!! Form::label('gender', trans('school_admin.gender'), array('class' => 'control-label')) !!}
            <div class="controls radiobutton">
                {!! Form::label('gender', trans('school_admin.female'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '0') !!}
                {!! Form::label('gender', trans('school_admin.male'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '1') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
            {!! Form::label('birth_date', trans('school_admin.birth_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('birth_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
            {!! Form::label('birth_city', trans('school_admin.birth_city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('birth_city', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('school_id') ? 'has-error' : '' }}">
            {!! Form::label('school_id', trans('school_admin.school'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('school_id', $school_ids, @isset($school_id)? $school_id : '', array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
            </div>
        </div>
        @if (!isset($school_admin))
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', trans('school_admin.password'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::text('password', "", array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                </div>
            </div>
        @endif

        @if(($custom_fields))
            {!! $custom_fields !!}
        @endif
            <div class="form-group">
                <label>{{trans('school_admin.select_permissions')}}</label>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" id="checkAll" class="icheckgreen">
                    {{trans('school_admin.check_all')}}
                </label>
            </div>
        @foreach(array_chunk($permission_groups ,4) as $row)
            <div class="row">
                @foreach($row as $key => $group)
                    <div class="col-md-3">
                        <p><strong>{{$group['group_name']}}</strong></p>
                        <div class="input-group">
                            @foreach($permissions as $permission)
                                @if($permission['group_name'] == $group['group_name'])
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{$group['group_slug'].'.'.str_slug($permission['name'])}}"
                                               class='{{($permission['name']=='show')?'icheckgreen':(($permission['name']=='delete')?'icheckred':'icheckblue')}}'
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
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#checkAll").on('ifChecked', function () {
                $("input:checkbox").iCheck('check');
            });
            $('.icheckgreen').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'
            });
            $('.icheckblue').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            $('.icheckred').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });

            $("input[value$='create'],input[value$='delete'],input[value$='edit']").on('ifChecked', function () {
                var item = $(this).val();
                var part = item.split('.');
                $("input[value='" + part[0] + ".show']").iCheck('check').iCheck('disable');
            });
            $("input[value$='create'],input[value$='delete'],input[value$='edit']").on('ifUnchecked', function () {
                var item = $(this).val();
                var part = item.split('.');
                if (!$("input[value='" + part[0] + ".create']").is(":checked") &&
                        !$("input[value='" + part[0] + ".edit']").is(":checked") &&
                        !$("input[value='" + part[0] + ".delete']").is(":checked")) {
                    $("input[value='" + part[0] + ".show']").iCheck('enable').iCheck('uncheck');
                }
            });
            $(".btn-success").click(function () {
                $("input").iCheck('enable');
            });
            $("input[type='checkbox']:checked").each(function () {
                var item = $(this).val();
                var part = item.split('.');
                if ($("input[value='" + part[0] + ".create']").is(":checked") ||
                        $("input[value='" + part[0] + ".edit']").is(":checked") ||
                        $("input[value='" + part[0] + ".delete']").is(":checked")) {
                    $("input[value='" + part[0] + ".show']").iCheck('check').iCheck('disable');
                }
            });
        });
    </script>
@stop