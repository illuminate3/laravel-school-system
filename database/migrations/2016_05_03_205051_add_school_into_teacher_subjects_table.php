<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolIntoTeacherSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->unsignedInteger('school_id')->default(0)->after('school_year_id');
            $table->foreign('school_id', 'teacher_subjects_school_id_foreign')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropForeign('teacher_subjects_school_id_foreign');
        });
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropColumn('school_id');
        });
    }
}
