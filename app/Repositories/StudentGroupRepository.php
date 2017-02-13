<?php

namespace App\Repositories;


interface StudentGroupRepository
{
    public function getAll();

    public function getAllForSchoolYearSchool($school_year_id, $school_id);

    public function getAllForSection($section_id);

}