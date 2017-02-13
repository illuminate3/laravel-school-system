<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RecreateHourWeekDayAndPeriodIntoTimetablesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->integer('week_day')->change();
            $table->integer('hour')->change();
            $table->integer('period')->change();
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
            $table->dropColumn('week_day');
            $table->dropColumn('hour');
            $table->dropColumn('period');
        });
        Schema::table('timetables', function (Blueprint $table) {
            $table->boolean('week_day')->after('teacher_subject_id');
            $table->boolean('hour')->after('week_day');
            $table->boolean('period')->after('hour');
        });
    }

}
