<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($markValue))
            {!! Form::model($markValue, array('url' => url($type) . '/' . $markValue->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('markvalue.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('direction_id') ? 'has-error' : '' }}">
            {!! Form::label('mark_system_id', trans('markvalue.mark_system'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('mark_system_id', array('' => trans('markvalue.select_mark_system')) + $mark_systems, @isset($markValue)? $markValue->mark_system_id : 'default', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mark_system_id', ':message') }}</span>
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