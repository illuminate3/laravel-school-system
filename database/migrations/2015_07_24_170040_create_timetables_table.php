<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimetablesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('teacher_subject_id');
            $table->foreign('teacher_subject_id')->references('id')->on('teacher_subjects')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->boolean('week_day');
            $table->boolean('hour');
            $table->boolean('period');
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
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropForeign('timetables_teacher_subject_id_foreign');
        });
        Schema::drop('timetables');
    }

}
