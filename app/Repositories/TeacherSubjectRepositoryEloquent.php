<?php

namespace App\Repositories;

use App\Models\TeacherSubject;

class TeacherSubjectRepositoryEloquent implements TeacherSubjectRepository
{
    /**
     * @var TeacherSubject
     */
    private $model;


    /**
     * TimetableRepositoryEloquent constructor.
     * @param TeacherSubject $model
     */
    public function __construct(TeacherSubject $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForGroup($group_id)
    {
        return $this->model->where('student_group_id', $group_id)
            ->distinct();
    }

    public function getAllForSubjectAndGroup($subject_id, $group_id)
    {
        return $this->model->where('student_group_id', $group_id)
            ->where('subject_id', $subject_id)
            ->distinct();
    }

    public function getAllForSchoolYearAndGroup($school_year_id, $group_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('student_group_id', $group_id)
            ->distinct();
    }

    public function getAllTeacherSubjectsForSchoolYearAndGroup($school_year_id, $student_group_id)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id)
            ->where('teacher_subjects.student_group_id', $student_group_id);
    }

    public function getAllForSchoolYearAndGroups($school_year_id, $student_group_ids)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id)
            ->whereIn('teacher_subjects.student_group_id', $student_group_ids);
    }

    public function getAllForSchoolYear($school_year_id)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id);
    }

    public function getAllForSchoolYearAndGroupAndTeacher($school_year_id, $group_id, $user_id)
    {
        return $this->model->where('teacher_subjects.school_year_id', $school_year_id)
            ->where('teacher_subjects.student_group_id', $group_id)
            ->where('teacher_subjects.teacher_id', $user_id);
    }

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id)
            ->distinct();
    }
}