@extends('layouts.secure')

@section('title')
    {{ $title }}
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
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
                        <table class="table table-hover">
                            <thead>
                            <td>{{trans('online_exam.question')}}</td>
                            <td>{{trans('online_exam.answer')}}</td>
                            <td>{{trans('online_exam.points')}}</td>
                            </thead>
                            <tbody>
                            @foreach($answeredUser as $item)
                                <tr>
                                    <td>{{$item->online_exam_question->title}}</td>
                                    <td>{{isset($item->online_exam_answer->title)?$item->online_exam_answer->title:$item->answer_text}}</td>
                                    <td>{{$item->points}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <a href="{{ url('online_exam/'.$onlineExam->id.'/show_results') }}"
                               class="btn btn-primary">{{trans('table.close')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('scripts')
    <script>
    </script>
@endsection