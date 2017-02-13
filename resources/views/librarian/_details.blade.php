<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('librarian.first_name')}}</label>
            <div class="controls">
                @if (isset($librarian)) {{ $librarian->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('librarian.last_name')}}</label>
            <div class="controls">
                @if (isset($librarian)) {{ $librarian->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('librarian.email')}}</label>
            <div class="controls">
                @if (isset($librarian)) {{ $librarian->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('librarian.gender')}}</label>
            <div class="controls">
                @if (isset($librarian)) {{ ($librarian->gender=='1')?trans('librarian.male'):trans('librarian.female') }} @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
            <div class="controls row">
                <div class="col-sm-3">
                    <img src="{{ url($librarian->picture) }}" alt="User Image" class="img-thumbnail">
                </div>
            </div>
        </div>
        @if(is_array($custom_fields))
            @foreach($custom_fields as $item)
                <div class="form-group">
                    <label class="control-label" for="title">{{ucfirst($item->name)}}</label>
                    <div class="controls">
                        {{ $item->value }}
                    </div>
                </div>
            @endforeach
        @endif
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