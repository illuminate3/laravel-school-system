<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDormitoryBedsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitory_beds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('dormitory_room_id');
            $table->foreign('dormitory_room_id', 'fk_dormitory_bad_dormitory_room1')->references('id')->on('dormitory_rooms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('student_id')->nullable();
            $table->foreign('student_id', 'fk_dormitory_beds_students1')->references('id')->on('students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::table('dormitory_beds', function (Blueprint $table) {
            $table->dropForeign('fk_dormitory_bad_dormitory_room1');
            $table->dropForeign('fk_dormitory_beds_students1');
        });
        Schema::drop('dormitory_beds');
    }

}
