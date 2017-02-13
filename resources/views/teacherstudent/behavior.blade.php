@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	{!! Form::open(array('url' => url($type.'/'.$student->id.'/changebehavior'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}

	<div class="form-group {{ $errors->has('behavior_id') ? 'has-error' : '' }}">
		{!! Form::label('behavior_id', trans('teacherstudent.behavior'), array('class' => 'control-label required')) !!}
		<div class="controls">
			{!! Form::select('behavior_id', $behaviors, null, array('id'=>'behavior_id', 'class' => 'form-control select2')) !!}
			<span class="help-block">{{ $errors->first('behavior_id', ':message') }}</span>
		</div>
	</div>
	<div class="form-group">
		<div class="controls">
			<a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
			<button type="submit" class="btn btn-success">{{trans('table.ok')}}</button>
		</div>
	</div>
	{!! Form::close() !!}
@stop

@section('scripts')
<script>
</script>
@endsection