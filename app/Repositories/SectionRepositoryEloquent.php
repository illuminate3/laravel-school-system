<?php

namespace App\Repositories;

use App\Models\Section;

class SectionRepositoryEloquent implements SectionRepository
{
    /**
     * @var Section
     */
    private $model;


    /**
     * SectionRepositoryEloquent constructor.
     * @param Section $model
     */
    public function __construct(Section $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchoolYear($school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id);
    }

    public function getAllForSchoolYearSchool($school_year_id, $school_id)
    {
        return $this->model->where('school_year_id', $school_year_id)->where('school_id', $school_id);
    }
}