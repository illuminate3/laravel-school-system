<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($teacher))
            {!! Form::model($teacher, array('url' => url($type) . '/' . $teacher->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('teacher.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('teacher.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('teacher.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('teacher.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('address', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('teacher.mobile'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('mobile', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            {!! Form::label('gender', trans('teacher.gender'), array('class' => 'control-label required')) !!}
            <div class="controls radiobutton">
                {!! Form::label('gender', trans('teacher.female'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '0') !!}
                {!! Form::label('gender', trans('teacher.male'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '1') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
            {!! Form::label('birth_date', trans('teacher.birth_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('birth_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
            {!! Form::label('birth_city', trans('teacher.birth_city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('birth_city', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
            </div>
        </div>
        @if (!isset($teacher))
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', trans('teacher.password'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::text('password', "", array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            {!! Form::label('image', trans('teacher.picture'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="controls row" v-image-preview>
                    <img src="{{ url(isset($teacher->picture)?$teacher->picture:"") }}"
                         class="img-l col-sm-2">
                    {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                    <img id="image-preview" width="300">
                    <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                </div>
            </div>
        </div>
        @if (isset($document_types))
            @foreach($document_types as $document_type)
                <div class="form-group {{ $errors->has('document') ? 'has-error' : '' }}">
                    {!! Form::label('document', $document_type['title'], array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::hidden('document_id', $document_type['value']) !!}
                        {!! Form::file('document', null, array('class' => 'form-control')) !!}
                        @if (isset($documents))
                            <a href="{{url('uploads/documents/'.$documents->document)}}">{{$documents->document}}</a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
        @if(($custom_fields))
            {!! $custom_fields !!}
        @endif
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>