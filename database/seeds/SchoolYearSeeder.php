<?php

use App\Models\SchoolYear;

class SchoolYearSeeder extends DatabaseSeeder
{
    public function run()
    {
        $school_year = new SchoolYear();
        $school_year->title = (date('Y') - 1) . "-" . date('Y');
        $school_year->save();
    }

}