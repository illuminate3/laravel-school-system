@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    @if(isset($teachergroup))
	{{trans('teachergroup.timetable_info')}}
	{!! Form::label('students', $teachergroup->title, array('class' => 'control-label')) !!}
    @endif
	<div class="row">
		<div class="col-sm-12">
			<div class="box-body">
				<table class="table table-bordered no-padding">
					<tbody>
					<tr>
						<th>#</th>
						<th width="14%">{{trans('teachergroup.monday')}}</th>
						<th width="14%">{{trans('teachergroup.tuesday')}}</th>
						<th width="14%">{{trans('teachergroup.wednesday')}}</th>
						<th width="14%">{{trans('teachergroup.thursday')}}</th>
						<th width="14%">{{trans('teachergroup.friday')}}</th>
                        <th width="14%">{{trans('teachergroup.saturday')}}</th>
                        <th width="14%">{{trans('teachergroup.sunday')}}</th>
					</tr>
						@for($i=1;$i<8;$i++)
                            <tr>
                                <td>{{$i}}</td>
                                @for($j=1;$j<8;$j++)
                                    <td id="{{$j}}-{{$i}}" class="droppable timetable_table">
                                        @foreach($timetable as $item)
                                            @if($item['week_day']==$j && $item['hour']==$i)
                                                <a class="btn btn-default" href="{{url('study_material/'.$item['subject_id'].'/subject')}}">
                                                    <span>{{$item['title']}}</span>
                                                    <br>
                                                    <span>{{$item['name']}}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                @endfor
						    </tr>
                        @endfor
					</tbody>
				</table>
			</div>
		</div>
</div>
    @if(isset($teachergroup))
    <div class="form-group">
        <div class="controls">
            <a href="{{ url($type) }}" class="btn btn-warning">{{trans('table.back')}}</a>
            <a href="{{ url($type).'/print_timetable' }}" target="_blank"
               class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> {{trans('table.print')}}</a>
        </div>
    </div>
        @else
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type).'/print_timetable' }}" target="_blank"
                   class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> {{trans('table.print')}}</a>
            </div>
        </div>
    @endif
{!! Form::close() !!}
@stop


