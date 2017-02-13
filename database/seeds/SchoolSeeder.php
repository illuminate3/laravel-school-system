<?php

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        if (\App::environment() === 'local') {
            $school = new School();
            $school->title = "First school";
            $school->active = 1;
            $school->phone = '545123';
            $school->save();
        }
    }

}