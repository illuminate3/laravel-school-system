<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="feedback_type">{{trans('feedback.feedback_type')}}</label>

            <div class="controls">
                @if (isset($feedback)) {{ $feedback->feedback_type}} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('feedback.title')}}</label>

            <div class="controls">
                @if (isset($feedback)) {{ $feedback->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('feedback.description')}}</label>

            <div class="controls">
                @if (isset($feedback)) {{ $feedback->description }} @endif
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