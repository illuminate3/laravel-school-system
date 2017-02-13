<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('direction_id');
            $table->foreign('direction_id')->references('id')->on('directions')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('title');
            $table->boolean('order')->nullable();
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
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign('subjects_direction_id_foreign');
        });
        Schema::drop('subjects');
    }

}
