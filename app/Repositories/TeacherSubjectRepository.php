<?php

namespace App\Repositories;


interface TeacherSubjectRepository
{
    public function getAll();

    public function getAllForGroup($group_id);

    public function getAllForSubjectAndGroup($subject_id, $group_id);

    public function getAllForSchoolYearAndGroup($school_year_id, $group_id);

    public function getAllForSchoolYearAndGroups($school_year_id, $student_group_ids);

    public function getAllForSchoolYear($school_year_id);

    public function getAllForSchoolYearAndGroupAndTeacher($school_year_id, $group_id, $user_id);

    public function getAllTeacherSubjectsForSchoolYearAndGroup($school_year_id, $group_id);

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id);
}