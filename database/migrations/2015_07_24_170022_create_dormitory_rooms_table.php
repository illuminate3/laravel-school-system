<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDormitoryRoomsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitory_rooms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('dormitory_id');
            $table->foreign('dormitory_id', 'fk_dormitory_bed_dormitories1')->references('id')->on('dormitories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('title');
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
        Schema::table('dormitory_rooms', function (Blueprint $table) {
            $table->dropForeign('fk_dormitory_bed_dormitories1');
        });
        Schema::drop('dormitory_rooms');
    }

}
