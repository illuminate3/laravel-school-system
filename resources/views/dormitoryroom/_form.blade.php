<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($dormitoryRoom))
            {!! Form::model($dormitoryRoom, array('url' => url($type) . '/' . $dormitoryRoom->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('dormitoryroom.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('dormitory_id') ? 'has-error' : '' }}">
            {!! Form::label('dormitory_id', trans('dormitoryroom.dormitory'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('dormitory_id', array('' => trans('dormitoryroom.select_dormitory')) + $dormitories,
                @isset($dormitoryRoom)? $dormitoryRoom->direction_id : 'default', array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('dormitory_id', ':message') }}</span>
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
