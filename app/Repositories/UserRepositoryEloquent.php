<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepositoryEloquent implements UserRepository
{
    /**
     * @var User
     */
    private $model;


    /**
     * SUserRepositoryEloquent constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

    public function getUsersForRole($role)
    {
        $users = new Collection([]);
        if($role == 'admin'){
            $this->model->with('school_admin', 'school_admin.school')->get()
                ->each(function ($user) use ($users) {
                    $users->push($user);
                });
        }else {
            $this->model->get()->each(function ($user) use ($users) {
                $users->push($user);
            });
        }
        $users = $users->filter(function ($user) use ($role) {
            return $user->inRole($role);
        });
        return $users;
    }

    public function getParentsAndStudents()
    {
        $users = new Collection([]);
        $this->model->with('student_parent.students')
            ->get()
            ->each(function ($user) use ($users) {
                $users->push($user);
            });
        $users = $users->filter(function ($user) {
            return $user->inRole('parent');
        });
        return $users;
    }
}