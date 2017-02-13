<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeMarkValue extends Migration
{

    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('mark');
        });

        Schema::table('marks', function (Blueprint $table) {
            $table->unsignedInteger('mark_value_id')->nullable()->after('subject_id');
            $table->foreign('mark_value_id', 'fk_marks_mark_values1')->references('id')->on('mark_values')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropForeign('fk_marks_mark_values1');
        });
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('mark_value_id');
        });

        Schema::table('marks', function (Blueprint $table) {
            $table->integer('mark')->after('subject_id');
        });
    }

}
