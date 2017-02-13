<?php

namespace App\Repositories;

use App\Models\Salary;

class SalaryRepositoryEloquent implements SalaryRepository
{
    /**
     * @var Salary
     */
    private $model;

    /**
     * SalaryRepositoryEloquent constructor.
     * @param Salary $model
     */
    public function __construct(Salary $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchoolYearSchool($school_id,$school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id)->where('school_id', $school_id);
    }

    public function getAllForSchoolMonthAndYear($school_id, $month, $year)
    {
        return $this->model->where('school_id', $school_id)
            ->where('date', 'LIKE', $year . '-' . $month . '%');
    }

    public function getAllForMonthAndYear($month, $year)
    {
        return $this->model->where('date', 'LIKE', $year . '-' . $month . '%');
    }

	public function getAllForSchoolYear( $school_year_id ) {
		return $this->model->where('school_year_id', $school_year_id);
	}
}