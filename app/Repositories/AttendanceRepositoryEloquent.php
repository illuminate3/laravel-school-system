<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\DB;

class AttendanceRepositoryEloquent implements AttendanceRepository
{
    /**
     * @var Attendance
     */
    private $model;


    /**
     * AttendanceRepositoryEloquent constructor.
     * @param Attendance $model
     */
    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForStudentsAndSchoolYear($students, $school_year_id)
    {
        return $this->model->whereIn('student_id', $students)
            ->where('school_year_id', $school_year_id);
    }

    public function getAllForSchoolYearAndBetweenDate($school_year_id, $start_date, $end_date)
    {
        return $this->model->with('student', 'student.user')
            ->orderBy('date')
            ->orderBy('hour')
            ->get()
            ->filter(function ($attendance) use ($school_year_id, $start_date, $end_date) {
                return ($attendance->school_year_id == $school_year_id &&
                    (Carbon::createFromFormat(Settings::get('date_format'), $attendance->date) >=
                        Carbon::createFromFormat(Settings::get('date_format'), $start_date)) &&
                    (Carbon::createFromFormat(Settings::get('date_format'), $attendance->date) <=
                        Carbon::createFromFormat(Settings::get('date_format'), $end_date)));
            });
    }

    public function getAllForSchoolYearSubjectuserAndSemester($school_year_id, $subject_id, $user_id, $semester_id)
    {
        return $this->model->with('student', 'student.user')
            ->orderBy('date')
            ->orderBy('hour')
            ->get()
            ->filter(function ($attendance) use ($school_year_id, $subject_id, $user_id, $semester_id) {
                return ($attendance->school_year_id == $school_year_id &&
                    $attendance->subject_id == $subject_id &&
                    isset($attendance->student->user) && $attendance->student->user_id == $user_id &&
                    (isset($semester_id) ? $attendance->semester_id == $semester_id : ""));
            });
    }

    public function getAllForSectionIdAndBetweenDate($section_id, $start_date, $end_date)
    {
        return $this->model->leftJoin('options', 'options.id', '=', 'attendances.option_id')
            ->groupBy('date')->groupBy('option_id')
            ->orderBy('date')->orderBy('option_id')
            ->select(DB::raw('count(attendances.hour) as hours'),'attendances.date','option_id', 'options.title')
            ->whereIn('student_id', Student::where('section_id',$section_id)->pluck('id')->toArray())
            ->get()
            ->filter(function ($attendance) use ($start_date, $end_date) {
                return ($attendance->option_id >0 && (Carbon::createFromFormat(Settings::get('date_format'), $attendance->date) >=
                        Carbon::createFromFormat(Settings::get('date_format'), $start_date)) &&
                    (Carbon::createFromFormat(Settings::get('date_format'), $attendance->date) <=
                        Carbon::createFromFormat(Settings::get('date_format'), $end_date)));
            });
    }

    public function getAllForStudentAndOptionAndBetweenDate($student_id, $option_id, $start_date, $end_date)
    {
        return $this->model->leftJoin('subjects', 'subjects.id', '=', 'attendances.subject_id')
            ->where('student_id', $student_id)
            ->where('option_id', $option_id)
            ->whereBetween('date', [Carbon::createFromFormat(Settings::get('date_format'), $start_date), Carbon::createFromFormat(Settings::get('date_format'), $end_date)])
            ->groupBy('subject_id')
            ->orderBy('subject_id')
            ->select(DB::raw('count(attendances.hour) as hours'),'subjects.title')
            ->pluck('title','hours')->toArray();
    }

    public function getAllForStudentGroupAndOptionAndBetweenDate($group_id, $option_id, $start_date, $end_date)
    {
        return $this->model->leftJoin('subjects', 'subjects.id', '=', 'attendances.subject_id')
            ->join('student_student_group', 'student_student_group.student_id', '=', 'attendances.student_id')
            ->where('student_student_group.student_group_id', $group_id)
            ->where('option_id', $option_id)
            ->whereNull('student_student_group.deleted_at')
            ->whereBetween('date', [Carbon::createFromFormat(Settings::get('date_format'), $start_date), Carbon::createFromFormat(Settings::get('date_format'), $end_date)])
            ->groupBy('subject_id')
            ->orderBy('subject_id')
            ->select(DB::raw('count(attendances.hour) as hours'),'subjects.title')
            ->pluck('title','hours')->toArray();
    }

    public function getAllForSectionAndOptionAndBetweenDate($section_id, $option_id, $start_date, $end_date)
    {
        return $this->model->leftJoin('subjects', 'subjects.id', '=', 'attendances.subject_id')
            ->join('students', 'students.id', '=', 'attendances.student_id')
            ->where('section_id', $section_id)
            ->where('option_id', $option_id)
            ->whereBetween('date', [Carbon::createFromFormat(Settings::get('date_format'), $start_date), Carbon::createFromFormat(Settings::get('date_format'), $end_date)])
            ->groupBy('subject_id')
            ->orderBy('subject_id')
            ->select(DB::raw('count(attendances.hour) as hours'),'subjects.title')
            ->pluck('title','hours')->toArray();
    }
}