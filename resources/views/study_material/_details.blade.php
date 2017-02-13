<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('study_material.title')}}</label>
            <div class="controls">
                @if (isset($studyMaterial)) {{ $studyMaterial->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('study_material.description')}}</label>
            <div class="controls">
                @if (isset($studyMaterial)) {{ $studyMaterial->description }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('study_material.subject')}}</label>
            <div class="controls">
                @if (isset($studyMaterial)) {{ $studyMaterial->subject->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="date">{{trans('study_material.date_off')}}</label>
            <div class="controls">
                @if (isset($studyMaterial)) {{ $studyMaterial->date_off }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="date">{{trans('study_material.file')}}</label>
            <div class="controls">
                @if (isset($studyMaterial))
                    <a href="{{ url(isset($studyMaterial->file)?$studyMaterial->file:"") }}">{{$studyMaterial->file}}</a>
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