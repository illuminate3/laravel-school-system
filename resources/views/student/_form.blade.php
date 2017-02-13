<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($student))
            {!! Form::model($student, array('url' => url($type) . '/' . $student->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('student.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('email', (isset($student->user->email)?$student->user->email:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('student.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', (isset($student->user->first_name)?$student->user->first_name:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('student.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', (isset($student->user->last_name)?$student->user->last_name:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('student.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('address', (isset($student->user->address)?$student->user->address:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('student.mobile'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mobile', (isset($student->user->mobile)?$student->user->mobile:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', trans('student.phone'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('phone', (isset($student->user->phone)?$student->user->phone:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            {!! Form::label('gender', trans('student.gender'), array('class' => 'control-label required')) !!}
            <div class="controls radiobutton">
                {!! Form::label('gender', trans('student.female'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '0',((isset($student->user->gender) && $student->user->gender==0)?true:null)) !!}
                {!! Form::label('gender', trans('student.male'), array('class' => 'control-label')) !!}
                {!! Form::radio('gender', '1',((isset($student->user->gender) && $student->user->gender==1)?true:null)) !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
            {!! Form::label('birth_date', trans('student.birth_date'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('birth_date', (isset($student->user->birth_date)?$student->user->birth_date:null), array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('birth_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('birth_city') ? 'has-error' : '' }}">
            {!! Form::label('birth_city', trans('student.birth_city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('birth_city', (isset($student->user->birth_city)?$student->user->birth_city:null), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('birth_city', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}">
            {!! Form::label('section_id', trans('student.section_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('section_id', $sections, null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
            {!! Form::label('order', trans('student.order'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('order', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('order', ':message') }}</span>
            </div>
        </div>
        @if (!isset($student))
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password', trans('student.password'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::password('password', array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            {!! Form::label('image', trans('accountant.picture'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="controls row" v-image-preview>
                    <img src="{{ url(isset($student->user->picture)?$student->user->picture:"") }}"
                         class="img-l col-sm-2">
                    {!! Form::file('image_file', null, array('id'=>'image_file', 'class' => 'form-control')) !!}
                    <img id="image-preview" width="300">
                    <span class="help-block">{{ $errors->first('image_file', ':message') }}</span>
                </div>
            </div>
        </div>
        @if (isset($document_types))
            @foreach($document_types as $document_type)
                <div class="form-group {{ $errors->has('document') ? 'has-error' : '' }}">
                    {!! Form::label('document', $document_type['title'], array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::hidden('document_id', $document_type['value']) !!}
                        {!! Form::file('document', null, array('class' => 'form-control')) !!}
                        @if (isset($documents))
                            <a href="{{url('uploads/documents/'.$documents->document)}}">{{$documents->document}}</a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
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