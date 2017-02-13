<?php

class RoleSeeder extends DatabaseSeeder
{

    public function run()
    {
        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Super Admin',
            'slug' => 'super_admin',
        ));
        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Admin',
            'slug' => 'admin',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Human resources',
            'slug' => 'human_resources',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Librarian',
            'slug' => 'librarian',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Teacher',
            'slug' => 'teacher',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Student',
            'slug' => 'student',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Parent',
            'slug' => 'parent',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Visitor',
            'slug' => 'visitor',
        ));

        Sentinel::getRoleRepository()->createModel()->create(array(
            'name' => 'Accountant',
            'slug' => 'accountant',
        ));

    }

}