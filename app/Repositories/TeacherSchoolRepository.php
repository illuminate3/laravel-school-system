<?php

namespace App\Repositories;

interface TeacherSchoolRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

    public function create(array $data, $activate = true);
}