<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_directions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->foreign('school_id', 'school_directions_school_id_foreign')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('direction_id');
            $table->foreign('direction_id', 'school_directions_direction_id_foreign')->references('id')->on('directions')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::table('school_directions', function (Blueprint $table) {
            $table->dropForeign('school_directions_school_id_foreign');
            $table->dropForeign('school_directions_direction_id_foreign');
        });
        Schema::drop('school_directions');
    }
}
