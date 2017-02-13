<?php

namespace App\Repositories;


interface SchoolRepository
{
    public function getAll();

    public function getAllAdmin();

    public function getAllTeacher();

    public function getAllStudent();
}