<?php

namespace App\Repositories;

use App\Models\SchoolDirection;

class SchoolDirectionRepositoryEloquent implements SchoolDirectionRepository
{
    /**
     * @var SchoolDirection
     */
    private $model;


    /**
     * SchoolDirectionEloquent constructor.
     * @param SchoolDirection $model
     */
    public function __construct(SchoolDirection $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchool($school_id)
    {
        return $this->model->where('school_id', $school_id);
    }
}