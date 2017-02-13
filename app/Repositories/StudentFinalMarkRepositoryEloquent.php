<?php

namespace App\Repositories;

use App\Models\StudentFinalMark;

class StudentFinalMarkRepositoryEloquent implements StudentFinalMarkRepository
{
    /**
     * @var StudentFinalMark
     */
    private $model;

    /**
     * StudentFinalMarkRepositoryEloquent constructor.
     * @param StudentFinalMark $model
     */
    public function __construct(StudentFinalMark $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForStudentAndSchoolYear($student_id, $school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('student_id', $student_id);
    }

    public function getAllForStudentSubjectSchoolYearSchool($student_id, $subject_id, $school_year_id, $school_id)
    {
        return $this->model->where('subject_id', $subject_id)
            ->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id)
            ->where('student_id', $student_id);
    }
}