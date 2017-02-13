<?php

namespace App\Repositories;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceRepositoryEloquent implements InvoiceRepository
{
    /**
     * @var Invoice
     */
    private $model;


    /**
     * InvoiceRepositoryEloquent constructor.
     * @param Invoice $model
     */
    public function __construct(Invoice $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

	public function getAllStudentsForSchool( $school_id ) {
		return $this->model->join('students', 'students.user_id', '=', 'invoices.user_id')
		                   ->where('school_id', $school_id)
		                   ->select('invoices.*');
	}

    public function getAllDebtor()
    {
        return $this->model->where('paid', 0)
            ->select('*', DB::raw('sum(amount) as amount'))
            ->groupBy('user_id');
    }

	public function getAllDebtorStudentsForSchool( $school_id ) {
		return $this->model->join('students', 'students.user_id', '=', 'invoices.user_id')
		                   ->where('school_id', $school_id)
							->where('paid', 0)
		                   ->select('*', DB::raw('sum(amount) as amount'))
		                   ->groupBy('invoices.user_id');
	}
}