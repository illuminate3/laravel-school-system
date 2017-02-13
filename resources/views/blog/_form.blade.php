<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($blog))
            {!! Form::model($blog, array('url' => url($type) . '/' . $blog->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('blog.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('blog_category_id') ? 'has-error' : '' }}">
            {!! Form::label('blog_category_id', trans('blog.blog_category'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('blog_category_id', $blog_categories, @isset($blog)? $blog->blog_category_id : 'default', array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('blog_category_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('content') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('blog.content'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('content', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            {!! Form::label('image', trans('blog.image'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="controls row" v-image-preview>
                    <img src="{{ url(isset($blog->image)?$blog->image:"") }}"
                         class="img-l col-sm-2">
                    {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                    <img id="image-preview" width="300">
                    <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('title', trans('blog.tags'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('tags', isset($blog)?$blog->tagList:null, array('class' => 'form-control tokenfield')) !!}
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
