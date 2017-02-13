<?php

namespace App\Repositories;

interface JoinDateRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

    public function getAllForSchoolAndStaff($school_id, $user_id);
}