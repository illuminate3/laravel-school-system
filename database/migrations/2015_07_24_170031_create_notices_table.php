<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNoticesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('notice_type_id');
            $table->foreign('notice_type_id', 'notices_type_notice_id_foreign')->references('id')->on('notice_types')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('subject_id');
            $table->foreign('subject_id', 'notices_subject_id_foreign')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'notices_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('school_year_id');
            $table->foreign('school_year_id', 'notices_school_year_id_foreign')->references('id')->on('school_years')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('title');
            $table->date('date');
            $table->text('description');
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
        Schema::table('notices', function (Blueprint $table) {
            $table->dropForeign('notices_subject_id_foreign');
            $table->dropForeign('notices_type_announcement_id_foreign');
            $table->dropForeign('notices_user_id_foreign');
            $table->dropForeign('notices_school_year_id_foreign');
        });
        Schema::drop('notices');
    }

}
