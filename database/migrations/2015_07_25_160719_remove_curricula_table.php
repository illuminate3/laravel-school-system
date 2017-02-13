<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveCurriculaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropForeign('fk_student_groups_school_years1');
        });
        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropColumn('school_year_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_groups', function (Blueprint $table) {
            $table->unsignedInteger('school_year_id');
            $table->foreign('school_year_id', 'fk_student_groups_school_years1')->references('id')->on('school_years')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

}
