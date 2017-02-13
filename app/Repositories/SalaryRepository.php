<?php

namespace App\Repositories;


interface SalaryRepository
{
    public function getAll();

    public function getAllForSchoolYearSchool($school_id,$school_year_id);

    public function getAllForSchoolMonthAndYear($school_id, $month, $year);

    public function getAllForMonthAndYear($month, $year);

	public function getAllForSchoolYear( $school_year_id );
}