<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="online_exam">{{trans('online_exam.title')}}</label>
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
        <div class="form-group">
            <label class="control-label">{{trans('online_exam.date_start')}}</label>
            <div class="controls">
                @if (isset($onlineExam))
                    {{ $onlineExam->date_start }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('online_exam.date_end')}}</label>
            <div class="controls">
                @if (isset($onlineExam))
                    {{ $onlineExam->date_end }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('online_exam.exam_time')}}</label>
            <div class="controls">
                @if (isset($onlineExam))
                    {{ $onlineExam->exam_time }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('online_exam.access_code')}}</label>
            <div class="controls">
                @if (isset($onlineExam))
                    {{ $onlineExam->access_code }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('online_exam.min_pass')}}</label>
            <div class="controls">
                @if (isset($onlineExam))
                    {{ $onlineExam->min_pass }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('online_exam.questions')}}</label>
            <div class="controls">
                @if (isset($onlineExam->questions))
                    @foreach($onlineExam->questions as $question)
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <label class="control-label">{{$question->title}} - {{$question->points}}</label>
                            </div>
                            @if (isset($question->answers))
                                <ul class="list-group">
                                    @foreach($question->answers as $answer)
                                        <li class="list-group-item @if($answer->correct_answer==1) active @endif">
                                            <label class="control-label">{{$answer->title}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
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

<style>
    .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover
    {
        border: none;
        background-color:transparent;
        color:#73879c;
    }
    .list-group-item.active:after {
        color: #3c763d;
        content: "\f00c";
        font-size: 18px;
        font-family: FontAwesome;
        font-weight: bold;
        margin-left: 5px;
    }
</style>