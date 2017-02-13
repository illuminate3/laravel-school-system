<?php

namespace App\Repositories;


interface StudentRepository
{
    public function getAll();

    public function getAllForSchoolYearAndSection($school_year_id, $section_id);

    public function getAllForSchoolYear($school_year_id);

    public function getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id);

    public function getAllForStudentGroup($student_group_id);

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id);

    public function getAllForSchoolYearSchoolAndSection($school_year_id, $school_id, $section_id);

    public function getSchoolForStudent($student_user_id, $school_year_id);

    public function create(array $data, $activate = true);

    public function getAllForSection($section_id);
}