<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'salaries_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('school_id');
            $table->foreign('school_id', 'schools_user_id_foreign')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('school_year_id');
            $table->foreign('school_year_id', 'school_years_user_id_foreign')->references('id')->on('school_years')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->double('salary');
            $table->date('date');
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
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropForeign('salaries_user_id_foreign');
            $table->dropForeign('schools_user_id_foreign');
            $table->dropForeign('school_years_user_id_foreign');
        });

        Schema::drop('salaries');
    }
}
