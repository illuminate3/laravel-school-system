<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('slider.title')}}</label>
            <div class="controls">
                @if (isset($slider)) {{ $slider->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="content">{{trans('slider.content')}}</label>
            <div class="controls">
                @if (isset($slider)) {{ $slider->content }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="url">{{trans('slider.url')}}</label>
            <div class="controls">
                @if (isset($slider)) {{ $slider->url }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="image">{{trans('slider.image')}}</label>
            <div class="controls">
                @if (isset($slider)) <img src="{{ url($slider->image) }}" > @endif
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