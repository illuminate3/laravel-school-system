<?php

namespace App\Repositories;


interface NoticeRepository
{
    public function getAll();

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id);

    public function getAllForSchoolYearAndGroup($school_year_id, $student_group, $user_id);
}