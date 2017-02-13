<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="student">{{trans('reservedbook.user_reserved')}}</label>

            <div class="controls">
                @if (isset($bookUser->user->id))
                    {{ $bookUser->user->full_name }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="book">{{trans('reservedbook.book')}}</label>

            <div class="controls">
                @if (isset($bookUser->book->id))
                    {{ $bookUser->book->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="reserved">{{trans('reservedbook.reserved')}}</label>
            <div class="controls">
                {{ $bookUser->reserved }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="reserved">{{trans('reservedbook.available')}}</label>
            <div class="controls">
                {{ $available }}
            </div>
        </div>
        @if (@$action == 'issue')
        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
            {!! Form::label('quantity', trans('reservedbook.quantity'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','quantity', null, array('class' => 'form-control','max' => $available)) !!}
                <span class="help-block">{{ $errors->first('quantity', ':message') }}</span>
            </div>
        </div>
        @endif
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                @if (@$action == 'issue')
                    <button type="submit"
                            class="btn btn-success" {{ (isset($available) && $available < 1) ? 'disabled' : '' }}>{{trans('reservedbook.issue')}}</button>
                @else
                    <button type="submit" class="btn btn-danger">{{trans('reservedbook.delete')}}</button>
                @endif

            </div>
        </div>
    </div>
</div>