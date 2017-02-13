<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($semester))
            {!! Form::model($semester, array('url' => url($type) . '/' . $semester->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('semester.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('school_year_id') ? 'has-error' : '' }}">
            {!! Form::label('school_year_id', trans('semester.school_year'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('school_year_id', array('' => trans('semester.select_school_year')) + $schoolyears, @isset($semester)? $semester->school_year_id : 'default', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('school_year_id', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('start') ? 'has-error' : '' }}">
            {!! Form::label('start', trans('semester.start'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('start', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('start', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('end') ? 'has-error' : '' }}">
            {!! Form::label('end', trans('semester.end'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('end', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('end', ':message') }}</span>
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
