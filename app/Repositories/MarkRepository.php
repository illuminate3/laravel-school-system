<?php

namespace App\Repositories;


interface MarkRepository
{
    public function getAll();

    public function getAllForSchoolYearAndBetweenDate($school_year_id, $date_start, $date_end);

    public function getAllForSchoolYearAndExam($school_year_id, $exam_id);

    public function getAllForSchoolYearSubjectUserAndSemester($school_year_id, $subject_id, $user_id, $semester_id);
}