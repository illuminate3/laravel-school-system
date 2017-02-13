<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($diary))
            {!! Form::model($diary, array('url' => url($type) . '/' . $diary->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
            {!! Form::label('subject_id', trans('diary.subject'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('diary.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('diary.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('diary.date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('hour') ? 'has-error' : '' }}">
            {!! Form::label('hour', trans('diary.hour'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('hour', isset($hour_list)?$hour_list:array(), null, array('id'=>'hour','class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('hour', ':message') }}</span>
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

@section('scripts')
    <script>
        $('.date').on('change keyup paste', function() {
            var date = $(this).val();
            if (date != "") {
                $('#hour').empty().select2("val", "");
                $.ajax({
                    type: "POST",
                    url: '{{ url('/attendance/hoursfordate') }}',
                    data: {_token: '{{ csrf_token() }}', date: date},
                    success: function (result) {
                        $('#hour').append($('<option></option>').val("").html("Select class"))
                        $.each(result, function (val, text) {
                            $('#hour').append($('<option></option>').val(text).html(text))
                        });
                    }
                });
            }
        });
    </script>
@endsection
