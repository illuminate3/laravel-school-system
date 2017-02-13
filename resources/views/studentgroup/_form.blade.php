<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($studentGroup))
            {!! Form::model($studentGroup, array('url' => url($type) . '/' . $studentGroup->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <input type="hidden" value="{{$section->id}}" name="section_id">

        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('studentgroup.name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        @if (!isset($studentgroup))
            <div class="form-group {{ $errors->has('direction_id') ? 'has-error' : '' }}">
                {!! Form::label('direction_id', trans('studentgroup.direction'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('direction_id', $directions, null, array('id'=>'direction_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('direction_id', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('class') ? 'has-error' : '' }}">
                {!! Form::label('class', trans('studentgroup.class'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('class', (!empty($class))?$class:array(), null, array('id'=>'class', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('class', ':message') }}</span>
                </div>
            </div>
            @endif

            <div class="form-group">
                <div class="controls">
                    <a href="{{ url('/section/'.$section->id.'/groups') }}"
                       class="btn btn-primary">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
                </div>
            </div>


            {!! Form::close() !!}
    </div>
</div>


@section('scripts')
    <script>
        $('#direction_id').change(function () {
            $('#class').empty().select2("val", "");
            if ($(this).val() != "") {
                $.ajax({
                    type: "GET",
                    url: '{{ url('/studentgroup/duration') }}',
                    data: {_token: '{{ csrf_token() }}', direction: $(this).val()},
                    success: function (result) {
                        $('#class').append($('<option></option>').val('').html("{!! trans('studentgroup.select_class') !!}")).select2("val", "");
                        for(var i=1;i<=result;i++) {
                            $('#class').append($('<option></option>').val(i).html(i));
                        }
                    }
                });
            }
        });
    </script>
@endsection