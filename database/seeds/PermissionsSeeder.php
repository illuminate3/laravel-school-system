<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Notice',
            'group_slug' => 'notice',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Notice',
            'group_slug' => 'notice',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Notice',
            'group_slug' => 'notice',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Notice',
            'group_slug' => 'notice',
            'name' => 'edit',
        ]);

        Permission::create([
            'role_id' => 2,
            'group_name' => 'Diary',
            'group_slug' => 'diary',
            'name' => 'show',
        ]);
        //sections
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Section',
            'group_slug' => 'section',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Section',
            'group_slug' => 'section',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Sections',
            'group_slug' => 'section',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Section',
            'group_slug' => 'section',
            'name' => 'edit',
        ]);

        //student_groups
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student group',
            'group_slug' => 'student_group',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student group',
            'group_slug' => 'student_group',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student group',
            'group_slug' => 'student_group',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student group',
            'group_slug' => 'student_group',
            'name' => 'edit',
        ]);

        //students
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Students',
            'group_slug' => 'student',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Students',
            'group_slug' => 'student',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Students',
            'group_slug' => 'student',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Students',
            'group_slug' => 'student',
            'name' => 'edit',
        ]);

        //student_final marks
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student final marks',
            'group_slug' => 'student_final_mark',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student final marks',
            'group_slug' => 'student_final_mark',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student final marks',
            'group_slug' => 'student_final_mark',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student final marks',
            'group_slug' => 'student_final_mark',
            'name' => 'edit',
        ]);

        //student attendances
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Student attendances',
            'group_slug' => 'student_attendances_admin',
            'name' => 'show',
        ]);


        //parents
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Parents',
            'group_slug' => 'parent',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Parents',
            'group_slug' => 'parent',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Parents',
            'group_slug' => 'parent',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Parents',
            'group_slug' => 'parent',
            'name' => 'edit',
        ]);

        //human resources
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Human resources',
            'group_slug' => 'human_resource',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Human resources',
            'group_slug' => 'human_resource',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Human resources',
            'group_slug' => 'human_resource',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Human resources',
            'group_slug' => 'human_resource',
            'name' => 'edit',
        ]);

        //teacher
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Teachers',
            'group_slug' => 'teacher',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Teachers',
            'group_slug' => 'teacher',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Teachers',
            'group_slug' => 'teacher',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Teachers',
            'group_slug' => 'teacher',
            'name' => 'edit',
        ]);
        //librarians
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Librarians',
            'group_slug' => 'librarian',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Librarians',
            'group_slug' => 'librarian',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Librarians',
            'group_slug' => 'librarian',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Librarians',
            'group_slug' => 'librarian',
            'name' => 'edit',
        ]);
        //accountants
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Accountants',
            'group_slug' => 'accountant',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Accountants',
            'group_slug' => 'accountant',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Accountants',
            'group_slug' => 'accountant',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Accountants',
            'group_slug' => 'accountant',
            'name' => 'edit',
        ]);
        //visitors
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Visitors',
            'group_slug' => 'visitor',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Visitors',
            'group_slug' => 'visitor',
            'name' => 'delete',
        ]);
        //scholarships
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Scholarships',
            'group_slug' => 'scholarship',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Scholarships',
            'group_slug' => 'scholarship',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Scholarships',
            'group_slug' => 'scholarship',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Scholarships',
            'group_slug' => 'scholarship',
            'name' => 'edit',
        ]);
        //salary
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Staff salary',
            'group_slug' => 'salary',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Staff salary',
            'group_slug' => 'salary',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Staff salary',
            'group_slug' => 'salary',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Staff salary',
            'group_slug' => 'salary',
            'name' => 'edit',
        ]);
        //fee_category
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Fee category',
            'group_slug' => 'fee_category',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Fee category',
            'group_slug' => 'fee_category',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Fee category',
            'group_slug' => 'fee_category',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Fee category',
            'group_slug' => 'fee_category',
            'name' => 'edit',
        ]);
        //sms_message
        Permission::create([
            'role_id' => 2,
            'group_name' => 'SMS message',
            'group_slug' => 'sms_message',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'SMS message',
            'group_slug' => 'sms_message',
            'name' => 'create',
        ]);
        //dormitory
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory',
            'group_slug' => 'dormitory',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory',
            'group_slug' => 'dormitory',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory',
            'group_slug' => 'dormitory',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory',
            'group_slug' => 'dormitory',
            'name' => 'edit',
        ]);
        //dormitory rooms
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory rooms',
            'group_slug' => 'dormitoryroom',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory rooms',
            'group_slug' => 'dormitoryroom',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory rooms',
            'group_slug' => 'dormitoryroom',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory rooms',
            'group_slug' => 'dormitoryroom',
            'name' => 'edit',
        ]);
        //dormitory beds
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory beds',
            'group_slug' => 'dormitorybed',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory beds',
            'group_slug' => 'dormitorybed',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory beds',
            'group_slug' => 'dormitorybed',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Dormitory beds',
            'group_slug' => 'dormitorybed',
            'name' => 'edit',
        ]);
        //transportation
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Transportation',
            'group_slug' => 'transportation',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Transportation',
            'group_slug' => 'transportation',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Transportation',
            'group_slug' => 'transportation',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Transportation',
            'group_slug' => 'transportation',
            'name' => 'edit',
        ]);
        //invoice
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Invoice',
            'group_slug' => 'invoice',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Invoice',
            'group_slug' => 'invoice',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Invoice',
            'group_slug' => 'invoice',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Invoice',
            'group_slug' => 'invoice',
            'name' => 'edit',
        ]);
        //debtor
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Debtor',
            'group_slug' => 'debtor',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Debtor',
            'group_slug' => 'debtor',
            'name' => 'create',
        ]);
        //payment
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Payments',
            'group_slug' => 'payment',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Payments',
            'group_slug' => 'payment',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Payments',
            'group_slug' => 'payment',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Payments',
            'group_slug' => 'payment',
            'name' => 'edit',
        ]);
        //holidays
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Holidays',
            'group_slug' => 'holiday',
            'name' => 'show',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Holidays',
            'group_slug' => 'holiday',
            'name' => 'create',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Holidays',
            'group_slug' => 'holiday',
            'name' => 'delete',
        ]);
        Permission::create([
            'role_id' => 2,
            'group_name' => 'Holidays',
            'group_slug' => 'holiday',
            'name' => 'edit',
        ]);
    }
}