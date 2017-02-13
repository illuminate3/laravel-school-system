<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParentStudentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_students', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id_parent');
            $table->foreign('user_id_parent', 'fk_parent_student_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('user_id_student');
            $table->foreign('user_id_student', 'fk_parent_student_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->boolean('activate')->default(0);
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
        Schema::table('parent_students', function (Blueprint $table) {
            $table->dropForeign('fk_parent_student_users1');
            $table->dropForeign('fk_parent_student_users2');
        });
        Schema::drop('parent_student');
    }

}
