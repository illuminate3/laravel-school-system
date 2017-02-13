<?php

namespace App\Repositories;


interface TransportationRepository
{
    public function getAll();

    public function getAllForSchool($school_id);
}