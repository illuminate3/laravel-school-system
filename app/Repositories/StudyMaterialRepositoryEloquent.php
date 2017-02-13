<?php

namespace App\Repositories;

use App\Models\StudyMaterial;

class StudyMaterialRepositoryEloquent implements StudyMaterialRepository
{
    /**
     * @var StudyMaterial
     */
    private $model;


    /**
     * StudyMaterialRepositoryEloquent constructor.
     * @param StudyMaterial $model
     */
    public function __construct(StudyMaterial $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForUser($user_id)
    {
        return $this->model->where('user_id', $user_id);
    }

    public function getAllForUserAndGroup($user_id, $student_group_id)
    {
        return $this->model->where('user_id', $user_id)->where('student_group_id', $student_group_id);
    }

    public function getAllForStudent($student_user_id)
    {
        return $this->model
            ->join('student_student_group', 'student_student_group.student_group_id', '=', 'study_materials.student_group_id')
            ->join('students', 'students.id', '=', 'student_student_group.student_id')
            ->where('students.user_id', $student_user_id)
            ->where('study_materials.date_off', '>=', date('Y-m-d'))
            ->select('study_materials.*');
    }
}