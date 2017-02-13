<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($dormitoryBed))
            {!! Form::model($dormitoryBed, array('url' => url($type) . '/' . $dormitoryBed->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('dormitorybed.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('dormitory_room_id') ? 'has-error' : '' }}">
            {!! Form::label('dormitory_room_id', trans('dormitorybed.room'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('dormitory_room_id', array('' => trans('dormitorybed.select_room')) + $dormitory_rooms, @isset($dormitoryBed)? $dormitoryBed->dormitory_room_id : 'default', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('dormitory_room_id', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('student_id') ? 'has-error' : '' }}">
            {!! Form::label('student_id', trans('dormitorybed.student'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('student_id', array('' => trans('dormitorybed.select_student')) + $students, @isset($dormitoryBed)? $dormitoryBed->student_id : 'default', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('student_id', ':message') }}</span>
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