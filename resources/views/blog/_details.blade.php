<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('blog.title')}}</label>
            <div class="controls">
                @if (isset($blog))
                    {{ $blog->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('blog.blog_category')}}</label>
            <div class="controls">
                @if (isset($blog->category))
                    {{ $blog->category->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('blog.content')}}</label>
            <div class="controls">
                @if (isset($blog))
                    {{ $blog->content }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('blog.image')}}</label>
            <div class="controls">
                @if (isset($blog))
                    <image src="{{ $blog->image }}"></image>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('blog.views')}}</label>
            <div class="controls">
                @if (isset($blog))
                    {{ $blog->views }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>