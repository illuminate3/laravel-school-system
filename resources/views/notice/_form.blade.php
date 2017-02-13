<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($notice))
            {!! Form::model($notice, array('url' => url($type) . '/' . $notice->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('notice_type_id') ? 'has-error' : '' }}">
            {!! Form::label('notice_type_id', trans('notice.notice_type'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('notice_type_id', $notice_type, null, array('id'=>'notice_type_id', 'class' => 'form-control required select2')) !!}
                <span class="help-block">{{ $errors->first('notice_type_id', ':message') }}</span>
            </div>
        </div>
        @if (Sentinel::inRole('teacher') || isset($notice))
            <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
                {!! Form::label('subject_id', trans('notice.subject'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
                </div>
            </div>
        @elseif(Sentinel::inRole('admin'))
            <div class="form-group {{ $errors->has('group_id') ? 'has-error' : '' }}">
                {!! Form::label('group_id', trans('notice.group'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('group_id[]', $groups, null, array('multiple'=>true, 'id'=>'group_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('group_id', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('notice.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('notice.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('notice.date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>

        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>


        {!! Form::close() !!}
    </div>
</div>
