<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderInJoinDatesAndStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('join_dates', function (Blueprint $table) {
            $table->dropColumn('date');
        });
        Schema::table('join_dates', function (Blueprint $table) {
            $table->date('date_start')->nullable()->after('id');
            $table->date('date_end')->nullable()->after('date_start');
        });

        Schema::table('staff_salaries', function (Blueprint $table) {
            $table->date('date_start')->nullable()->after('id');
            $table->date('date_end')->nullable()->after('date_start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('join_dates', function (Blueprint $table) {
            $table->dropColumn('date_start');
            $table->dropColumn('date_end');
        });
        Schema::table('join_dates', function (Blueprint $table) {
            $table->date('date')->after('id');
        });

        Schema::table('staff_salaries', function (Blueprint $table) {
            $table->dropColumn('date_start');
            $table->dropColumn('date_end');
        });
    }
}
