<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentSuccessTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_success', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->foreign('student_id', 'fk_student_success_students1')->references('id')->on('students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('subject_id');
            $table->foreign('subject_id', 'fk_student_success_subjects1')->references('id')->on('subjects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('semester_id');
            $table->foreign('semester_id', 'fk_student_success_periods1')->references('id')->on('semesters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('mark', 45);
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
        Schema::table('student_success', function (Blueprint $table) {
            $table->dropForeign('fk_student_success_semesters1');
            $table->dropForeign('fk_student_success_students1');
            $table->dropForeign('fk_student_success_subjects1');
        });
        Schema::drop('student_success');
    }

}
