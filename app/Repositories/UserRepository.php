<?php

namespace App\Repositories;


interface UserRepository
{
    public function getAll();

    public function getUsersForRole($role);

    public function getParentsAndStudents();
}