<?php

namespace App\Repositories;

use App\Models\ParentStudent;

class ParentStudentRepositoryEloquent implements ParentStudentRepository
{
    /**
     * @var ParentStudent
     */
    private $model;

    /**
     * ParentStudentRepositoryEloquent constructor.
     * @param ParentStudent $model
     */
    public function __construct(ParentStudent $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}