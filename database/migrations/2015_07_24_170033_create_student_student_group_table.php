<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentStudentGroupTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_student_group', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('student_groups_id');
            $table->foreign('student_groups_id', 'fk_student_student_group_student_groups1')->references('id')->on('student_groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('students_id');
            $table->foreign('students_id', 'fk_student_student_group_students1')->references('id')->on('students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_student_group', function (Blueprint $table) {
            $table->dropForeign('fk_student_student_group_student_groups1');
            $table->dropForeign('fk_student_student_group_students1');
        });
        Schema::drop('student_student_group');
    }

}
