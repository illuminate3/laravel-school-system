<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RecreateJustifiedIntoAttendancesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('justified')->default('unknown');
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('justified')->nullable()->after('note');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('justified');
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->tinyInteger('justified')->after('note');
        });
    }

}
