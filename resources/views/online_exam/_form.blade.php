<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($onlineExam))
            {!! Form::model($onlineExam, array('url' => url($type) . '/' . $onlineExam->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('online_exam.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('internal', trans('online_exam.description'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('subject_id') ? 'has-error' : '' }}">
            {!! Form::label('subject_id', trans('online_exam.subject'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('subject_id', array('' => trans('online_exam.select_subject')) + $subjects, @isset($onlineExam)? $onlineExam->subject_id : 'default', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('date_start') ? 'has-error' : '' }}">
            {!! Form::label('date_start', trans('online_exam.date_start'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date_start', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date_start', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('date_end') ? 'has-error' : '' }}">
            {!! Form::label('date_end', trans('online_exam.date_end'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date_end', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date_end', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('exam_time') ? 'has-error' : '' }}">
            {!! Form::label('exam_time', trans('online_exam.exam_time'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('exam_time', 0, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('exam_time', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('min_pass') ? 'has-error' : '' }}">
            {!! Form::label('min_pass', trans('online_exam.min_pass'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('min_pass', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('min_pass', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('access_code') ? 'has-error' : '' }}">
            {!! Form::label('access_code', trans('online_exam.access_code'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('access_code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('access_code', ':message') }}</span>
            </div>
        </div>
        <button type="button" class="btn btn-info btn-ghost " id="add"><i
                    class="fa fa-plus"></i> {!! trans('online_exam.add_question') !!}</button>
        <div class="row">
            <ul id="sortable">
                @if (isset($onlineExam->questions))
                    @foreach($onlineExam->questions as $key2 => $question)
                        <li class="ui-state-default question" id="form">
                            <div class="form-group">
                                {!! Form::label('question', trans('online_exam.question'), array('class' => 'control-label')) !!}
                                <div class="controls">
                                    {!! Form::text('question['.$key2.']', $question->title, array('class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('points', trans('online_exam.points'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('points['.$key2.']', $question->points, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('answers_type', trans('online_exam.answers_type'), array('class' => 'control-label required')) !!}
                                    <div class="controls">
                                        {!! Form::select('answers_type['.$key2.']', $answers_types, $question->answers_type, array('class' => 'form-control answers_type select2')) !!}
                                    </div>
                                </div>
                                @if (isset($question->answers))
                                    <div class="form-group">
                                        {!! Form::label('answers', trans('online_exam.answers'), array('class' => 'control-label')) !!}
                                        <div class="controls answers">
                                            @if($question->answers_type==$answers_type_text)
                                                @foreach($question->answers as $key => $answer)
                                                    {!! Form::text('answers['.$key.'][]', $answer->title, array('class' => 'form-control')) !!}
                                                @endforeach
                                            @elseif($question->answers_type==$answers_type_one)
                                                <div class="row">
                                                    @foreach($question->answers as $key => $answer)
                                                        <div class="col-sm-2">
                                                            {!! Form::text('answers['.$key2.'][]', $answer->title, array('class' => 'form-control', "placeholder"=> trans("online_exam.answer"). " ".($key+1))) !!}
                                                            <input type="radio" value="1" @if($answer->correct_answer==1) checked @endif name="correct_answer[{{$key2}}][{{$key}}]"> {{trans("online_exam.correct_answer")}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif($question->answers_type==$answers_type_multi)
                                                <div class="row">
                                                    @foreach($question->answers as $key => $answer)
                                                    <div class="col-sm-2">
                                                        {!! Form::text('answers['.$key2.'][]', $answer->title, array('class' => 'form-control', "placeholder"=> trans("online_exam.answer"). " ".($key+1))) !!}
                                                        <input type="checkbox" value="1" @if($answer->correct_answer==1) checked @endif name="correct_answer[{{$key2}}][{{$key}}]"> {{trans("online_exam.correct_answer")}}
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        <a class="btn btn-default btn-sm btn-small remove">
                                            <span class="fa fa-trash-o">
                                                {!! Form::hidden('remove', $question->id, array('class' => 'remove')) !!}
                                            </span>
                                        </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="ui-state-default question" id="form">
                        <div class="form-group">
                            {!! Form::label('question', trans('online_exam.question'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('question[0]', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('points', trans('online_exam.points'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('points[0]', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('answers_type', trans('online_exam.answers_type'), array('class' => 'control-label required')) !!}
                            <div class="controls">
                                {!! Form::select('answers_type[0]', $answers_types, null, array('class' => 'form-control answers_type select2')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('answers', trans('online_exam.answers'), array('class' => 'control-label')) !!}
                            <div class="controls answers">
                                {!! Form::text('answers[0][]', null, array('class' => 'form-control')) !!}
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
        <style>
            ul {
                list-style-type: none;
            }

            .question {
                border: #1dad6b double;
            }
        </style>
        @section('scripts')
            <script>
                $(document).ready(function () {
                    $('.remove').click(function () {
                        $(this).parent().parent().parent().parent().remove();
                    });
                    var count = {{isset($onlineExam)?(count($onlineExam->questions)-1):'0'}};
                    $("#add").click(function () {
                        count++;
                        var formfild = '<li class="ui-state-default question" id="form' + count + '">' +
                                '<div class="form-group">' +
                                '<label class="control-label" for="question">{!! trans('online_exam.question')!!}</label>' +
                                '<div class="controls">' +
                                '<input type="text" class="form-control" value="" name="question[' + count + ']">' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="control-label" for="points">{!! trans('online_exam.points')!!}</label>' +
                                '<div class="controls">' +
                                '<input type="text" class="form-control" value="" name="points[' + count + ']">' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="control-label" for="answers_type">{!! trans('online_exam.answers_type')!!}</label>' +
                                '<div class="controls">' +
                                '<select name="answers_type[' + count + ']" class="form-control answers_type">';
                        @foreach($answers_types as $key => $item)
                                formfild += '<option value="{{$key}}">{{$item}}</option>';
                        @endforeach
                                formfild += '</select>' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="control-label" for="answers">{!! trans('online_exam.answers')!!}</label>' +
                                '<div class="controls answers">' +
                                '<input type="text" class="form-control" value="" name="answers[' + count + '][]">' +
                                '</div>' +
                                '</div>' +
                                '</li>';
                        $("#sortable").append(formfild);
                        $('.answers_type').on('change', function () {
                            changeAnswerType($(this));
                        });
                    })
                    $("#sortable").sortable();

                    $('.answers_type').on('change', function () {
                        changeAnswerType($(this));
                    });
                });

                function changeAnswerType(type) {
                    var answers_type = $(type).val();
                    var answers_type_name = $(type).attr('name');
                    var name_num_1 = answers_type_name.split('[');
                    var name_num_2 = name_num_1[1].split(']');
                    var name_num = name_num_2[0];
                    var answers_div = '';
                    if (answers_type == {{$answers_type_text}}) {
                        answers_div = '<div class="row"><div class="col-sm-10">' +
                                '<input type="text" placeholder="{{trans("online_exam.correct_answer")}}" class="form-control" name="answers[' + name_num + '][]">' +
                                '</div></div>';
                    }
                    else if (answers_type == {{$answers_type_one}}) {
                        answers_div = '<div class="row"><div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 1" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="radio" value="1" name="correct_answer[' + name_num + '][0]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 2" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="radio" value="1" name="correct_answer[' + name_num + '][1]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 3" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="radio" value="1" name="correct_answer[' + name_num + '][2]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 4" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="radio" value="1" name="correct_answer[' + name_num + '][3]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 5" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="radio" value="1" name="correct_answer[' + name_num + '][4]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '</div>';
                    }
                    else if (answers_type == {{$answers_type_multi}}) {
                        answers_div = '<div class="row"><div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 1" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="checkbox" value="1" name="correct_answer[' + name_num + '][0]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 2" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="checkbox" value="1" name="correct_answer[' + name_num + '][1]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 3" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="checkbox" value="1" name="correct_answer[' + name_num + '][2]">{{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 4" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="checkbox" value="1" name="correct_answer[' + name_num + '][3]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<input type="text" placeholder="{{trans("online_exam.answer")}} 5" class="form-control" name="answers[' + name_num + '][]">' +
                                '<input type="checkbox" value="1" name="correct_answer[' + name_num + '][4]"> {{trans("online_exam.correct_answer")}}' +
                                '</div>' +
                                '</div>';
                    }
                    $(type).parent().parent().parent().find('.answers').html(answers_div);
                }
                ;
            </script>
        @endsection
    </div>
</div>