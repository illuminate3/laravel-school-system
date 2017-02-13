<?php

namespace App\Repositories;


interface DiaryRepository
{
    public function getAll();

    public function getAllForSchoolYear($school_year_id);

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id);

    public function getAllForSchoolYearAndStudentUserId($school_year_id, $student_user_id);
}