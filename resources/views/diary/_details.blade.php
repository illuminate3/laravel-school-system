<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('diary.title')}}</label>

            <div class="controls">
                @if (isset($diary)) {{ $diary->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('diary.description')}}</label>

            <div class="controls">
                @if (isset($diary)) {{ $diary->description }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('diary.subject')}}</label>

            <div class="controls">
                @if (isset($diary)) {{ $diary->subject->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="date">{{trans('diary.date')}}</label>

            <div class="controls">
                @if (isset($diary)) {{ $diary->date }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="date">{{trans('diary.hour')}}</label>

            <div class="controls">
                @if (isset($diary)) {{ $diary->hour }} @endif
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