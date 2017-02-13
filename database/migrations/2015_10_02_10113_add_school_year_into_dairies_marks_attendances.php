<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSchoolYearIntoDairiesMarksAttendances extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diaries', function (Blueprint $table) {
            $table->unsignedInteger('school_year_id')->nullable()->after('hour');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });

        Schema::table('marks', function (Blueprint $table) {
            $table->unsignedInteger('school_year_id')->nullable()->after('date');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedInteger('school_year_id')->nullable()->after('date');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('diaries', function (Blueprint $table) {
            $table->dropForeign('dairies_school_year_id_foreign');
        });

        Schema::table('diaries', function (Blueprint $table) {
            $table->dropColumn('school_year_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign('attendances_school_year_id_foreign');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('school_year_id');
        });

        Schema::table('marks', function (Blueprint $table) {
            $table->dropForeign('marks_school_year_id_foreign');
        });

        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('school_year_id');
        });
    }

}
