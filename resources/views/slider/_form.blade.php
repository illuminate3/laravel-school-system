<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($slider))
            {!! Form::model($slider, array('url' => url($type) . '/' . $slider->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('slider.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                {!! Form::label('content', trans('slider.content'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('content', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                {!! Form::label('url', trans('slider.url'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('url', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('url', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                {!! Form::label('image', trans('slider.image'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    <div class="controls row" v-image-preview>
                        <img src="{{ url(isset($slider->image)?$slider->image:"") }}"
                             class="img-l col-sm-2">
                        {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                        <img id="image-preview" width="300">
                        <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                    </div>
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
