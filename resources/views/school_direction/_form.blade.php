<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($schoolDirection))
            {!! Form::model($schoolDirection, array('url' => url($type) . '/' . $schoolDirection->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('school_id') ? 'has-error' : '' }}">
            {!! Form::label('school_id', trans('school_direction.school'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('school_id', $school_ids, null, array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('direction_id') ? 'has-error' : '' }}">
            {!! Form::label('direction_id', trans('school_direction.direction'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('direction_id', $direction_ids, null, array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('direction_id', ':message') }}</span>
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