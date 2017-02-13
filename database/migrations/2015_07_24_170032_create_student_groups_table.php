<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('school_year_id');
            $table->foreign('school_year_id', 'fk_student_groups_school_years1')->references('id')->on('school_years')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('section_id');
            $table->foreign('section_id', 'fk_student_groups_sections1')->references('id')->on('sections')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('direction_id');
            $table->foreign('direction_id', 'fk_student_groups_directions1')->references('id')->on('directions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('title');
            $table->boolean('class');
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
        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropForeign('fk_student_groups_directions1');
            $table->dropForeign('fk_student_groups_school_years1');
            $table->dropForeign('fk_student_groups_sections1');
        });
        Schema::drop('student_groups');
    }

}
