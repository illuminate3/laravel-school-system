<?php

namespace App\Repositories;


interface StaffAttendanceRepository
{
    public function getAllForSchool($school_id);

    public function getAllForSchoolYear($school_year_id);

    public function getAllForSchoolSchoolYear($school_id, $school_year_id);

    public function getAllForSchoolSchoolYearStaff($school_id, $school_year_id, $staff_id);
}