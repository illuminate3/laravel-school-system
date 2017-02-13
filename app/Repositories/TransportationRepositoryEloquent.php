<?php

namespace App\Repositories;

use App\Models\Transportation;

class TransportationRepositoryEloquent implements TransportationRepository
{
    /**
     * @var Transportation
     */
    private $model;

    /**
     * TransportationRepositoryEloquent constructor.
     * @param Transportation $model
     */
    public function __construct(Transportation $model)
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