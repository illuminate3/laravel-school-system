<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('notice.title')}}</label>

            <div class="controls">
                @if (isset($notice)) {{ $notice->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('notice.description')}}</label>

            <div class="controls">
                @if (isset($notice)) {{ $notice->description }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="notice_type">{{trans('notice.notice_type')}}</label>

            <div class="controls">
                @if (isset($notice)) {{ $notice->notice_type->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('notice.subject')}}</label>

            <div class="controls">
                @if (isset($notice)) {{ $notice->subject->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="date">{{trans('notice.date')}}</label>

            <div class="controls">
                @if (isset($notice)) {{ $notice->date }} @endif
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