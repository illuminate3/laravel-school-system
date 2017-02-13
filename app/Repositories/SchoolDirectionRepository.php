<?php

namespace App\Repositories;


interface SchoolDirectionRepository
{
    public function getAll();

    public function getAllForSchool($school_id);
}