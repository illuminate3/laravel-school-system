<?php

namespace App\Repositories;


interface SubjectRepository
{
    public function getAll();

    public function getAllForDirectionAndClass($direction_id, $class);

    public function getAllStudentsSubjectAndDirection();

    public function getAllStudentsSubjectsTeacher($student_user_id, $school_year_id);

    public function create(array $data);
}