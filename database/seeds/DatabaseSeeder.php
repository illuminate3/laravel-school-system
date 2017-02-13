<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('RoleSeeder');
        $this->call('SettingSeeder');
        //$this->call('CitySeeder');
        //$this->call('StateSeeder');
        //$this->call('CountrySeeder');
        $this->call('OptionSeeder');
        $this->call('SchoolYearSeeder');
        $this->call('VersionSeeder');
        //$this->call('SchoolSeeder');
        //$this->call('TeacherSeeder');
        $this->call('PermissionsSeeder');
        $this->call('ThemeSeeder');

        Model::reguard();
    }

}
