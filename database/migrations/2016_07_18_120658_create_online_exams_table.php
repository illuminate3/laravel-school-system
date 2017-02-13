<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'fk_online_exams_users1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('subject_id')->nullable();
            $table->foreign('subject_id', 'fk_online_exams_subject_id_foreign')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('student_group_id')->nullable();
            $table->foreign('student_group_id', 'fk_online_exams_student_group_id_foreign')->references('id')->on('student_groups')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('title');
            $table->text('description');
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('exam_time');
            $table->double('min_pass', 6, 2);
            $table->string('access_code')->nullable();
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
            $table->dropForeign('fk_online_exams_users1');
            $table->dropForeign('fk_online_exams_subject_id_foreign');
            $table->dropForeign('fk_online_exams_student_group_id_foreign');
        });

        Schema::drop('online_exams');
    }
}
