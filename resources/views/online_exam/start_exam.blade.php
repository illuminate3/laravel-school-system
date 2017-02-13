@extends('layouts.secure')

@section('title')
    {{ $title }}
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="panel-title">{{$title}}</div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('online_exam.title')}}</label>
                        <div class="controls">
                            @if (isset($onlineExam))
                                {{ $onlineExam->title }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">{{trans('online_exam.description')}}</label>
                        <div class="controls">
                            @if (isset($onlineExam))
                                {{ $onlineExam->description }}
                            @endif
                        </div>
                    </div>
                    @if($onlineExam->exam_time>0)
                       <label class="control-label">{{trans('online_exam.time_left')}}</label>
                        <div class="timer" data-seconds-left={{$onlineExam->exam_time*60}}></div>
                    @endif
                    @if(strlen($onlineExam->access_code)>0)
                        <div class="form-group" id="access_code">
                            {!! Form::label('access_code', trans('online_exam.access_code'), array('class' => 'control-label required')) !!}
                            <div class="controls">
                                {!! Form::text('exam_access_code', null, array('class' => 'form-control', 'id'=>"exam_access_code")) !!}
                            </div>
                            <button type="button" class="btn btn-info"
                                    id="submit_access_code">{{trans('online_exam.submit_access_code')}}</button>
                        </div>
                    @endif
                    {!! Form::open(array('url' => url('online_exam/'.$onlineExam->id.'/submit_answers'), 'method' => 'post')) !!}
                    <div class="form-group" id="questions">
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-success" id="submit_online_exam">{{trans('online_exam.submit')}}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <style>
        .timer, .timer-done, .timer-loop {
            font-size: 20px;
            color: black;
            font-weight: bold;
            padding: 10px;
        }

        .hours { float: left; }
        .minutes { float: left; }
        .seconds { float: left; }
        .clearDiv { clear: both; }

        .is-complete {
            color: red;
            -webkit-animation-name: blinker;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: cubic-bezier(1.0,0,0,1.0);
            -webkit-animation-duration: 1s;
        }
        @-webkit-keyframes blinker {
            from { opacity: 1.0; }
            to { opacity: 0.0; }
        }
    </style>
@stop
@section('scripts')
    <script>
        $( document ).ready(function() {
                $('#submit_access_code').click(function () {
                $.ajax({
                    type: "POST",
                    url: '{{ url('/online_exam/'.$onlineExam->id.'/submit_access_code') }}',
                    data: {_token: '{{ csrf_token() }}', access_code: $('#exam_access_code').val()},
                    success: function (data) {
                        if (data == '1') {
                            loadQuestions();
                        }
                    }
                });
            });
            function loadQuestions() {
                var questions = "";
                @foreach($onlineExam->questions as $question)
                        questions += '<label class="control-label" for="question">{{$question->title}}</label>' +
                    '<div class="controls">';
                    @if($question->answers_type==$answers_type_text)
                        @foreach($question->answers as $key => $answer)
                            questions += '<input type="text" name="answers[{{$question->id}}][{{$answer->id}}][]" class="form-control">';
                        @endforeach
                    @elseif($question->answers_type==$answers_type_one)
                        questions += '<div class="row">';
                        @foreach($question->answers as $key => $answer)
                                questions += '<div class="col-sm-2">'
                                        +'<label class="control-label" for="question">{{$answer->title}}</label> '
                                +'<input type="radio" value="1" name="answers[{{$question->id}}][{{$answer->id}}]"></div>';
                        @endforeach
                        questions += '</div>';
                    @elseif($question->answers_type==$answers_type_multi)
                        questions += '<div class="row">';
                        @foreach($question->answers as $key => $answer)
                                questions += '<div class="col-sm-2">'
                                +'<label class="control-label" for="question">{{$answer->title}}</label> '
                                +'<input type="checkbox" value="1" name="answers[{{$question->id}}][{{$answer->id}}]"></div>';
                        @endforeach
                                questions += '</div>';
                    @endif
                        questions +='</div>';
                @endforeach
                $('#questions').html(questions);
                $('#access_code').html('');

                $('.timer').startTimer({
                    onComplete: function(element){
                        element.addClass('is-complete');
                        $('#submit_online_exam').trigger('click');
                    }
                });
            }

            @if(strlen($onlineExam->access_code)==0)
                loadQuestions();
            @endif
        });
    </script>
@endsection