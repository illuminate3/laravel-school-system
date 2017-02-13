<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepositoryEloquent implements SubjectRepository
{
    /**
     * @var Subject
     */
    private $model;

    /**
     * SubjectRepositoryEloquent constructor.
     * @param Subject $model
     */
    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForDirectionAndClass($direction_id, $class)
    {
        return $this->model->where('direction_id', $direction_id)
            ->where('class', $class);
    }

    public function getAllStudentsSubjectAndDirection()
    {
        return $this->model->join('directions', 'subjects.direction_id', '=', 'directions.id')
            ->join('student_groups', function ($join) {
                $join->on('student_groups.direction_id', '=', 'directions.id');
                $join->on('student_groups.class', '=', 'subjects.class');
            })
            ->join('student_student_group', 'student_student_group.student_group_id', '=', 'student_groups.id')
            ->join('students', 'students.id', '=', 'student_student_group.student_id');
    }

    public function getAllStudentsSubjectsTeacher($student_user_id, $school_year_id)
    {
        return $this->model->join('teacher_subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
            ->join('student_student_group', 'student_student_group.student_group_id', '=', 'teacher_subjects.student_group_id')
            ->join('students', 'students.id', '=', 'student_student_group.student_id')
            ->join('users', 'users.id', '=', 'teacher_subjects.teacher_id')
            ->where('students.user_id', $student_user_id)
            ->where('students.school_year_id', $school_year_id)
            ->select('users.*')
            ->distinct();
    }

    public function create(array $data)
    {
        $subject = new Subject($data);
        $subject->save();

        return $subject;
    }
}