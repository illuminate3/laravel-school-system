<?php

namespace App\Repositories;


interface SectionRepository
{
    public function getAll();

    public function getAllForSchoolYear($school_year_id);

    public function getAllForSchoolYearSchool($school_year_id, $school_id);
}