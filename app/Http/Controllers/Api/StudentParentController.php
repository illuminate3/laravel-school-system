<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diary;
use App\Models\Exam;
use App\Models\Notice;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Traits\TimeTableTrait;
use App\Http\Controllers\Traits\AttendanceTrait;
use App\Http\Controllers\Traits\MarksTrait;
use JWTAuth;
use Illuminate\Http\Request;
use Validator;
use DB;

/**
 * Student adn parent endpoints, can be accessed only with role "student" or "parent"
 *
 * @Resource("Student", uri="/student_parent")
 */
class StudentParentController extends Controller
{
    use Helpers;
    use TimeTableTrait;
    use MarksTrait;
    use AttendanceTrait;

    /**
     * Get timetable classes for student for selected school year and day (day: 1-Monday,... 7-Sunday)
     *
     * @Get("/timetable_day")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "day_id":"1", "student_id":"1"}),
     *      @Response(200, body={
    "timetable":
    {
    "1": {"id": 10, "subject": "English", "teacher": "Test teacher 1"},
    "2": {"id": 11, "subject": "Serbian", "teacher": "Test teacher 2"},
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     *
     */
    public function timetableDay(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
            'day_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            return response()->json($this->studentsTimetableDayAPI($request->input('student_id'), $request->input('day_id')), 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * List of subjects and teachers for student
     *
     * Get list of subjects and teachers for student
     *
     * @Get("/subject_list")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1"}),
     *      @Response(200, body={
    "subject_list":
    {
    "id": 4,
    "subject": "history",
    "teacher": "Teacher 1"
    },
    {
    "id": 1,
    "subject": "english",
    "teacher": "Teacher 2"
    },
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     *
     */
    public function subjectList(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            return response()->json($this->studentsTimetableSubjectsDayAPI($request->input('student_id')), 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     *Get all attendances for student for date
     *
     * @Get("/attendances_date")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1", "date":"2015-10-12"}),
     *      @Response(200, body={
    "attendance": {
    {
    "id": 1,
    "subject": "English",
    "hour": "2",
    "option": "Present",
    "option_id": "1",
    "date": "2015-10-19"
    }
    }
    }),
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function attendancesDate(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
            'date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $request->date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d');

            $attendance = $this->listAttendanceStudentDateAPI($request->input('student_id'), $request->date);

            return response()->json(['attendance' => $attendance], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Exams for teacher group
     *
     * Get all exams for teacher group
     *
     * @Get("/exams_date")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1", "date":"2016-08-22"}),
     *      @Response(200, body={
    "exams": {
    {
    "id": 1,
    "title": "This is title of exam",
    "description": "This is description of exam",
    "subject": "English"
    }
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function examsDate(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
            'date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $request->date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d');

            $exams = Exam::join('subjects', 'subjects.id', '=', 'exams.subject_id')
                ->join('student_student_group', 'student_student_group.student_group_id', '=', 'exams.student_group_id')
                ->where('student_student_group.student_id', $request->input('student_id'))
                ->where('exams.date', $request->date)
                ->select(array('exams.id', 'exams.title', 'exams.description', 'subjects.title as subject'))
                ->get()->toArray();

            return response()->json(['exams' => $exams], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get all marks for student for selected date
     *
     * @Get("/marks_date")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1", "date": "2015-10-22"}),
    @Response(200, body={
    "marks": {
    {
    "id": 1,
    "subject": "Subject Name",
    "mark_type": "Oral",
    "mark_value": "A+",
    "exam": "Exam 1",
    "date": "2015-10-22"
    }
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *      })
     * })
     */
    public function marksDate(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
            'date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $request->date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d');

            $marks = $this->listMarksStudent($request->date, $request->input('student_id'));
            return response()->json(['marks' => $marks], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }


    /**
     * Get all notices for student and date
     *
     * @Get("/notices_date")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1", "date": "2015-10-22"}),
     *      @Response(200, body={
    "notice": {
    {
    "id": 1,
    "title": "This is title of notice",
    "subject": "English",
    "description": "This is description of notice",
    }
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function noticesDate(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
            'date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $request->date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d');

            $notices = Notice::join('subjects', 'subjects.id', '=', 'notices.subject_id')
                ->join('student_student_group', 'student_student_group.student_group_id', '=', 'notices.student_group_id')
                ->where('student_student_group.student_id', $request->input('student_id'))
                ->where('notices.date', $request->date)
                ->select(array('notices.id', 'notices.title', 'subjects.title as subject', 'notices.description'))
                ->get()->toArray();

            return response()->json(['notice' => $notices], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get all diaries for student and selected date
     *
     * @Get("/diary_date")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1", "date":"2015-10-10"}),
     *      @Response(200, body={
    "diaries": {
    {
    "id": 1,
    "title": "This is title of notice",
    "subject": "English",
    "description": "This is description of notice",
    "hour": "2",
    "date": "2015-02-02"
    }
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function diaryForDate(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
            'date' => 'required|date',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $dairies = Diary::join('subjects', 'subjects.id', '=', 'diaries.subject_id')
                ->join('teacher_subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
                ->join('student_student_group', 'student_student_group.student_group_id', '=', 'teacher_subjects.student_group_id')
                ->where('student_student_group.student_id', $request->input('student_id'))
                ->where('diaries.date', $request->input('date'))
                ->orderBy('diaries.date', 'DESC')
                ->orderBy('diaries.hour', 'DESC')
                ->select(array('diaries.id', 'diaries.title', 'subjects.title as subject', 'diaries.hour', 'diaries.date'))
                ->get()->toArray();

            return response()->json(['diaries' => $dairies], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }
}
