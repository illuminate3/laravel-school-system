<?php

namespace App\Repositories;

use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Session;
use Sentinel;

class StudentRepositoryEloquent implements StudentRepository
{
    /**
     * @var Student
     */
    private $model;


    /**
     * StudentRepositoryEloquent constructor.
     * @param Student $model
     */
    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getAllForSchoolYearAndSection($school_year_id, $section_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('section_id', $section_id);
    }

    public function getAllForSchoolYear($school_year_id)
    {
        return $this->model->where('school_year_id', $school_year_id)->with('user');
    }

    public function getAllStudentGroupsForStudentUserAndSchoolYear($student_user_id, $school_year_id)
    {
        $studentgroups = new Collection([]);
        $this->model->with('user', 'studentsgroups')
            ->get()
            ->filter(function ($studentItem) use ($student_user_id, $school_year_id) {
                return (isset($studentItem->user) &&
                    $studentItem->user->id == $student_user_id &&
                    $studentItem->school_year_id == $school_year_id);
            })
            ->each(function ($studentItem) use ($studentgroups) {
                foreach ($studentItem->studentsgroups as $studentsgroup) {
                    $studentgroups->push($studentsgroup->id);
                }
            });
        return $studentgroups;
    }

    public function getAllForStudentGroup($student_group_id)
    {
        $studentitems = new Collection([]);
        $this->model->with('user', 'studentsgroups')
            ->orderBy('order')
            ->get()
            ->each(function ($studentItem) use ($studentitems, $student_group_id) {
                foreach ($studentItem->studentsgroups as $studentsgroup) {
                    if ($studentsgroup->id == $student_group_id) {
                        $studentitems->push($studentItem);
                    }
                }
            });
        return $studentitems;
    }

    public function getAllForSchoolYearAndSchool($school_year_id, $school_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id);
    }

    public function getAllForSchoolYearSchoolAndSection($school_year_id, $school_id, $section_id)
    {
        return $this->model->where('school_year_id', $school_year_id)
            ->where('school_id', $school_id)
            ->where('section_id', $section_id);
    }

    public function getSchoolForStudent($student_user_id, $school_year_id)
    {
        return $this->model->whereIn('user_id', $student_user_id)->where('school_year_id', $school_year_id);
    }


    public function create(array $data, $activate = true)
    {
        $user_exists = User::where('email', $data['email'])->first();
        if (!isset($user_exists->id)) {
            $user_tem = Sentinel::registerAndActivate($data, $activate);
            $user = User::find($user_tem->id);
        } else {
            $user = $user_exists;
        }
        try {
            $role = Sentinel::findRoleBySlug('student');
            $role->users()->attach($user);
        } catch (\Exception $e) {
        }
        $user->update(['birth_date'=>$data['birth_date'],
                        'birth_city'=>$data['birth_city'],
                        'gender' => $data['gender'],
                        'address' => $data['address'],
                        'mobile' => $data['mobile'],
                        'phone' => $data['phone']]);

        $student = new Student();
        $student->section_id = $data['section_id'];
        $student->order = $data['order'];
        $student->school_year_id = session('current_school_year');
        $student->school_id = session('current_school');
        $student->user_id = $user->id;
        $student->save();

        $school = School::find(session('current_school'));
        $student->student_no = $school->student_card_prefix . $student->id;
        $student->save();


        return $user;
    }

    public function getAllForSection($section_id)
    {
        $studentitems = new Collection([]);
        $this->model->with('user')
            ->orderBy('order')
            ->get()
            ->each(function ($studentItem) use ($studentitems, $section_id) {
                if ($studentItem->section_id == $section_id && isset($studentItem->user)) {
                    $studentitems->push($studentItem);
                }
            });
        return $studentitems;
    }
}