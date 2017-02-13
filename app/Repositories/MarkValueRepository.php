<?php

namespace App\Repositories;


interface MarkValueRepository
{
    public function getAll();

    public function getAllForSubject($subject_id);
}