<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">

        @if (isset($transportation))
            {!! Form::model($transportation, array('url' => url($type) . '/' . $transportation->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('transportation.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <button type="button" class="btn btn-info btn-ghost " id="add"><i
                    class="fa fa-plus"></i> {!! trans('transportation.add_location') !!}</button>
        <div class="row">
            <ul id="sortable">
                @if (isset($transportation))
                    @foreach($transportation->locations as $location)
                        <li class="ui-state-default" id="form">
                            <div class="form-group">
                                {!! Form::label('location', trans('transportation.location'), array('class' => 'control-label')) !!}
                                <div class="controls">
                                    {!! Form::text('location[]', $location->name, array('class' => 'form-control')) !!}
                                </div>
                                <a class="btn btn-default btn-sm btn-small remove">
                            <span class="fa fa-trash-o">
                            {!! Form::hidden('remove', $location->id, array('class' => 'remove')) !!}
                            </span>
                                </a>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="ui-state-default" id="form">
                        <div class="form-group">
                            {!! Form::label('location', trans('transportation.location'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('location[]', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
        @section('scripts')
            <style>
                ul {
                    list-style-type: none;
                }
            </style>
            <script>
                $(document).ready(function () {
                    $('.remove').click(function () {
                        $(this).parent().parent().remove();
                    });
                    var count = {{isset($transportation)?count($transportation->locations):'0'}};
                    $("#add").click(function () {
                        count++;
                        var formfild = '<li class="ui-state-default" id="form' + count + '">' +
                                '<div class="form-group">' +
                                '<label class="control-label" for="location">{!! trans('transportation.location')!!}</label>' +
                                '<div class="controls">' +
                                '<input type="text" class="form-control" id="location[]" value="" name="location[]">' +
                                '</div>' +
                                '</div>' +
                                '</li>';
                        $("#sortable").append(formfild);
                    })
                    $("#sortable").sortable();
                });
            </script>
        @endsection
    </div>
</div>