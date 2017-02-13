<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeAttendanceTable extends Migration
{

    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('justified');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedInteger('option_id')->default(0)->after('note');
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
            $table->dropColumn('option_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->string('justified')->after('note');
        });
    }

}
