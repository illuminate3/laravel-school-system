<?php

namespace App\Repositories;


interface InvoiceRepository
{
    public function getAll();

	public function getAllStudentsForSchool($school_id);

    public function getAllDebtor();

	public function getAllDebtorStudentsForSchool($school_id);
}