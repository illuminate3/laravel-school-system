<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($parentStudent))
            {!! Form::model($parentStudent, array('url' => url($type) . '/' . $parentStudent->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email', trans('parent.email'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::text('email', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('parent.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', isset($parentStudent->first_name)?$parentStudent->first_name:"", array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('parent.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', isset($parentStudent->last_name)?$parentStudent->last_name:"", array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('parent.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('address', isset($parentStudent->address)?$parentStudent->address:"", array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('parent.mobile'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mobile', isset($parentStudent->mobile)?$parentStudent->mobile:"", array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', trans('parent.phone'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('phone', isset($parentStudent->phone)?$parentStudent->phone:"", array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            {!! Form::label('gender', trans('parent.gender'), array('class' => 'control-label')) !!}
            <div class="controls radiobutton">
                {!! Form::label('gender', trans('parent.female'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '0',(isset($parentStudent->gender) && $parentStudent->gender==0)?true:false) !!}
                {!! Form::label('gender', trans('parent.male'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '1',(isset($parentStudent->gender) && $parentStudent->gender==1)?true:false) !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
            {!! Form::label('birth_date', trans('parent.birth_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('birth_date', isset($parentStudent->birth_date)?$parentStudent->birth_date:"", array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
            {!! Form::label('birth_city', trans('parent.birth_city'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('birth_city', isset($parentStudent->birth_city)?$parentStudent->birth_city:"", array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('student_id') ? 'has-error' : '' }}">
            {!! Form::label('student_id', trans('parent.student'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('student_id[]', $students, (isset($students_ids)?$students_ids:null), array('id'=>'student_id', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('student_id', ':message') }}</span>
            </div>
        </div>
        @if (!isset($parentStudent))
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', trans('parent.password'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::password('password', array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            {!! Form::label('image', trans('parent.picture'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="controls row" v-image-preview>
                    <img src="{{ url(isset($parentStudent->picture)?$parentStudent->picture:"") }}"
                         class="img-l col-sm-2">
                    {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                    <img id="image-preview" width="300">
                    <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                </div>
            </div>
        </div>
        @if(($custom_fields))
            {!! $custom_fields !!}
        @endif
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>