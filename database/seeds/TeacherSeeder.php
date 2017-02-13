<?php

use App\Models\TeacherSchool;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App::environment() === 'local') {

            $teachers = factory(\App\Models\User::class, 100)->create();
            $teacherRole = Sentinel::getRoleRepository()->findByName('teacher');

            $teachers->each(function ($teacher) use ($teacherRole) {
                $teacherRole->users()->attach($teacher);

                TeacherSchool::firstOrCreate(['user_id' => $teacher->id, 'school_id' => 1]);

            });

        }
    }
}
