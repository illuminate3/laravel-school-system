<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->foreign('school_id', 'teacher_schools_school_id_foreign')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'teacher_schools_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::table('teacher_schools', function (Blueprint $table) {
            $table->dropForeign('teacher_schools_school_id_foreign');
            $table->dropForeign('teacher_schools_user_id_foreign');
        });
        Schema::drop('teacher_schools');
    }
}
