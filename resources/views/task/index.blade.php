@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary todolist">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="medal" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        {{trans('task.tasks')}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="todolist_list adds">
                        {!! Form::open(['class'=>'form', 'id'=>'main_input_box']) !!}
                        {!! Form::hidden('task_from_user',$user->id, ['id'=>'task_from_user']) !!}
                        <div class="form-group">
                            {!! Form::label('task_description', trans('task.description'), array('class'=>'required')) !!}
                            {!! Form::text('task_description', null, ['class' => 'form-control','id'=>'task_description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('task_deadline', trans('task.deadline')) !!}
                            <div class="control" style="position: relative">
                                {!! Form::text('task_deadline', null, ['class' => 'form-control date required','id'=>'task_deadline']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('user_id', trans('task.user')) !!}
                            {!! Form::select('user_id', $users , null, ['class' => 'form-control select2','id'=>'user_id']) !!}
                        </div>
                        {!!  Form::hidden('full_name', $user->full_name, ['id'=> 'full_name'])!!}
                        <button type="submit" class="btn btn-primary add_button">
                            Send
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="inbox" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        {{trans('task.created_tasks')}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row list_of_items">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script src="{{ asset('js/todolist.js') }}"></script>
@stop