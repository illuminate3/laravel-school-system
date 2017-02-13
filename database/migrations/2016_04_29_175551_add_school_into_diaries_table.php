<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolIntoDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diaries', function (Blueprint $table) {
            $table->unsignedInteger('school_id')->nullable()->after('school_year_id');
            $table->foreign('school_id', 'diaries_school_id_foreign')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
            $table->dropForeign('diaries_school_id_foreign');
        });
        Schema::table('diaries', function (Blueprint $table) {
            $table->dropColumn('school_id');
        });
    }
}
