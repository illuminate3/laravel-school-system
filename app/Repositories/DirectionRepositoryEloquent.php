<?php

namespace App\Repositories;

use App\Models\Direction;

class DirectionRepositoryEloquent implements DirectionRepository
{
    /**
     * @var Direction
     */
    private $model;


    /**
     * DirectionRepositoryEloquent constructor.
     * @param Direction $model
     */
    public function __construct(Direction $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}