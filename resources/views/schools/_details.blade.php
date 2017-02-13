<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('schools.title')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="address">{{trans('schools.address')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->address }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="phone">{{trans('schools.phone')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->phone }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">{{trans('schools.email')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="student_card_prefix">{{trans('schools.student_card_prefix')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->student_card_prefix }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="about">{{trans('schools.about')}}</label>
            <div class="controls">
                @if (isset($school)) {{ $school->about }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="photo">{{trans('schools.photo')}}</label>
            <div class="controls">
                @if (isset($school))
                    <img src="{{ url($school->photo) }}" class="img-thumbnail">
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="student_card_background">{{trans('schools.student_card_background')}}</label>
            <div class="controls">
                @if (isset($school))
                    <img src="{{ url($school->student_card_background) }}" class="img-thumbnail">
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