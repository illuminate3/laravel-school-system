<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'fk_study_materials_users1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('subject_id')->nullable();
            $table->foreign('subject_id', 'study_materials_subject_id_foreign')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('student_group_id')->nullable();
            $table->foreign('student_group_id', 'study_materials_student_group_id_foreign')->references('id')->on('student_groups')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('title');
            $table->text('description');
            $table->string('file');
            $table->date('date_off')->nullable();
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
        Schema::table('study_materials', function (Blueprint $table) {
            $table->dropForeign('fk_exams_users1');
            $table->dropForeign('exams_subject_id_foreign');
            $table->dropForeign('exams_student_group_id_foreign');
        });

        Schema::drop('study_materials');
    }
}
