<?php namespace App\Repositories;


interface OptionRepository
{
    public function getAll();

    public function getAllForSchool($school_id);
}