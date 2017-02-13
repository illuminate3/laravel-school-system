<?php

namespace App\Repositories;


interface ApplyingLeaveRepository
{
    public function getAll();

    public function getAllForStudentAndSchoolYear($student_id, $school_year_id);
}