<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('subject.title')}}</label>

            <div class="controls">
                @if (isset($subject))
                    {{ $subject->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="direction">{{trans('subject.direction')}}</label>

            <div class="controls">
                @if (isset($subject) && $subject->direction() != null)
                    {{ $subject->direction()->first()->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="class">
                @if (isset($subject))
                    @if($subject->class == null || $subject->class == "" || $subject->class == 0 )
                        {{trans('subject.no_grade')}}
                    @else
                        {{ trans('subject.subject_is')}} {{$subject->class}}. {{trans('subject.grade') }}.
                    @endif
                @endif
            </label>
        </div>
        <div class="form-group">
            <label class="control-label" for="order">{{trans('subject.order')}}</label>
            <label class="control-label" for="order">
                @if (isset($subject))
                    {{ ($subject->order != null && $subject->order != "" && $subject->order != 0 ) ? $subject->order : trans('subject.not_defined') }}
                    .
                @endif
            </label>
        </div>
        <div class="form-group">
            <label class="control-label" for="order">{{trans('subject.fee')}}</label>
            <label class="control-label" for="order">
                @if (isset($subject))
                    {{ $subject->fee }}
                @endif
            </label>
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