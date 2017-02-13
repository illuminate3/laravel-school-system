<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepositoryEloquent implements PaymentRepository
{
    /**
     * @var Payment
     */
    private $model;

    /**
     * PaymentRepositoryEloquent constructor.
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

	public function getAllStudentsForSchool( $school_id ) {
		return $this->model->join('students', 'students.user_id', '=', 'payments.user_id')
		                   ->where('school_id', $school_id)
		                   ->select('payments.*');
	}
}