<?php

namespace App\Repositories;

use App\Models\Mark;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;

class MarkRepositoryEloquent implements MarkRepository
{
    /**
     * @var Mark
     */
    private $model;


    /**
     * MarkRepositoryEloquent constructor.
     * @param Mark $model
     */
    public function __construct(Mark $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchoolYearAndBetweenDate($school_year_id, $date_start, $date_end)
    {
        return $this->model->with('student', 'student.user', 'mark_type', 'mark_value', 'subject')
            ->orderBy('date')
            ->get()
            ->filter(function ($marksItem) use ($school_year_id, $date_start, $date_end) {
                return ($marksItem->school_year_id == $school_year_id &&
                    (Carbon::createFromFormat(Settings::get('date_format'), $marksItem->date) >=
                        Carbon::createFromFormat(Settings::get('date_format'), $date_start) &&
                        (Carbon::createFromFormat(Settings::get('date_format'), $marksItem->date) <=
                            Carbon::createFromFormat(Settings::get('date_format'), $date_end))));
            });

    }

    public function getAllForSchoolYearAndExam($school_year_id, $exam_id)
    {
        return $this->model->with('student', 'student.user', 'mark_type', 'mark_value', 'subject')
            ->orderBy('date')
            ->get()
            ->filter(function ($marksItem) use ($school_year_id, $exam_id) {
                return ($marksItem->school_year_id == $school_year_id &&
                    $marksItem->exam_id == $exam_id);
            });

    }

    public function getAllForSchoolYearSubjectUserAndSemester($school_year_id, $subject_id, $user_id, $semester_id)
    {
        return $this->model->with('student', 'student.user', 'mark_type', 'mark_value', 'subject')
            ->orderBy('date')
            ->get()
            ->filter(function ($marksItem) use ($school_year_id, $subject_id, $user_id) {
                return ($marksItem->school_year_id == $school_year_id &&
                    $marksItem->subject_id == $subject_id &&
                    isset($marksItem->student->user) && $marksItem->student->user_id == $user_id &&
                    ((isset($semester_id)) ? $marksItem->semester_id == $semester_id : true));
            });

    }
}