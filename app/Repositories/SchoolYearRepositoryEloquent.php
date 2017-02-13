<?php

namespace App\Repositories;

use App\Models\SchoolYear;

class SchoolYearRepositoryEloquent implements SchoolYearRepository
{
    /**
     * @var SchoolYear
     */
    private $model;


    /**
     * SchoolYearRepositoryEloquent constructor.
     * @param SchoolYear $model
     */
    public function __construct(SchoolYear $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}