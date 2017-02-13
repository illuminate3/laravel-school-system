<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($customUserField))
            {!! Form::model($customUserField, array('url' => url($type) . '/' . $customUserField->id, 'method' => 'put', 'id' => 'custom-field-form')) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'id' => 'custom-field-form')) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('custom_user_field.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('role_id') ? 'has-error' : '' }}">
            {!! Form::label('role_id', trans('custom_user_field.role'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('role_id', array('' => trans('custom_user_field.select_role')) + $roles, @isset($customUserField)? $customUserField->role_id : 'default', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('role_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('type') ? 'has-error' : '' }}">
            {!! Form::label('type', trans('custom_user_field.type'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('type', $types, @isset($customUserField)? $customUserField->type : 'default', array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('type', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('is_required', trans('custom_user_field.is_required'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="form-inline">
                    <div class="radio">
                        {!! Form::radio('is_required', '0',(@isset($customUserField) && $customUserField->is_required=='0')?true:false,array('id'=>'is_required','class' => 'is_required'))  !!}
                        {!! Form::label('0', trans('custom_user_field.no'))  !!}
                    </div>
                    <div class="radio">
                        {!! Form::radio('is_required', '1', (@isset($customUserField) && $customUserField->is_required=='1')?true:false,array('id'=>'is_required','class' => 'is_required'))  !!}
                        {!! Form::label('1', trans('custom_user_field.yes')) !!}
                    </div>
                </div>
                <span class="help-block">{{ $errors->first('about_school_page', ':message') }}</span>
            </div>
        </div>
        <div class="custom-field-option">
            <div class="form-group">
                {!! Form::label('options', trans('custom_user_field.options_comma'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('options', null, array('class' => 'form-control tokenfield')) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

