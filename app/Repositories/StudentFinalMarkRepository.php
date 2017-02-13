<?php

namespace App\Repositories;


interface StudentFinalMarkRepository
{
    public function getAll();

    public function getAllForStudentAndSchoolYear($student_id, $school_year_id);

    public function getAllForStudentSubjectSchoolYearSchool($student_id, $subject_id, $school_year_id, $school_id);
}