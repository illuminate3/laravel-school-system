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
                                <td>{{trans('online_exam.student')}}</td>
                                <td>{{trans('online_exam.final_points')}}</td>
                                <td>{{trans('online_exam.detail_results')}}</td>
                                <td></td>
                            </thead>
                            <tbody>
                            @foreach($answered_array as $item)
                                <tr>
                                    <td>{{$item['student']}}</td>
                                    <td>{{$item['result']}}</td>
                                    <td><a class="btn btn-sm btn-success"
                                           href="{{url('online_exam/'.$onlineExam->id.'/'.$item['user_id'].'/details')}}">
                                            <i class="fa fa-info-circle"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <a href="{{ url('online_exam') }}"
                               class="btn btn-primary">{{trans('table.close')}}</a>
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