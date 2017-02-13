<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($studyMaterial))
            {!! Form::model($studyMaterial, array('url' => url($type) . '/' . $studyMaterial->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
            {!! Form::label('subject_id', trans('study_material.subject'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('study_material.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('study_material.description'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('date_off') ? 'has-error' : '' }}">
            {!! Form::label('date_off', trans('study_material.date_off'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date_off', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date_off', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
            {!! Form::label('file_file', trans('study_material.file'), array('class' => 'control-label required')) !!}
            <div class="controls">
                <a href="{{ url(isset($studyMaterial->file)?$studyMaterial->file:"") }}">
                    {{isset($studyMaterial->file)?$studyMaterial->file:""}}</a>
                {!! Form::file('file_file', null, array('id'=>'file_file', 'class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('file_file', ':message') }}</span>
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
