<?php

namespace App\Repositories;


interface PaymentRepository
{
    public function getAll();

	public function getAllStudentsForSchool($school_id);
}