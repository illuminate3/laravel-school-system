<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($joinDate))
            {!! Form::model($joinDate, array('url' => url($type) . '/' . $teacher->id. '/' . $joinDate->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type). '/' . $teacher->id, 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('school_id') ? 'has-error' : '' }}">
            {!! Form::label('school_id', trans('join_date.school'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('school_id', $schools_list, null, array('id'=>'school_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('date_start') ? 'has-error' : '' }}">
            {!! Form::label('date_start', trans('join_date.join_start_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date_start', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date_start', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('date_end') ? 'has-error' : '' }}">
            {!! Form::label('date_end', trans('join_date.join_end_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date_end', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date_end', ':message') }}</span>
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