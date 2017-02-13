<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddGroupIdIntoNoticesTable extends Migration
{

    public function up()
    {
        Schema::table('notices', function (Blueprint $table) {
            $table->unsignedInteger('student_group_id')->nullable()->after('subject_id');
            $table->foreign('student_group_id', 'notices_student_group_id_foreign')->references('id')->on('student_groups')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
            $table->dropForeign('notices_student_group_id_foreign');
        });
        Schema::table('notices', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
    }

}
