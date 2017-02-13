<?php

namespace App\Repositories;

use App\Models\FeeCategory;

class FeeCategoryRepositoryEloquent implements FeeCategoryRepository
{
    /**
     * @var FeeCategory
     */
    private $model;


    /**
     * FeeCategoryRepositoryEloquent constructor.
     * @param FeeCategory $model
     */
    public function __construct(FeeCategory $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}