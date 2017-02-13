<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeExamIntoMarksTable extends Migration
{

    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropForeign('fk_marks_exams1');
        });
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('exam_id');
        });

        Schema::table('marks', function ($table) {
            $table->unsignedInteger('exam_id')->nullable()->after('id');
            $table->foreign('exam_id', 'fk_marks_exams1')->references('id')->on('exams')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->dropForeign('fk_marks_exams1');
        });
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('exam_id');
        });

        Schema::table('marks', function ($table) {
            $table->unsignedInteger('exam_id')->after('id');
            $table->foreign('exam_id', 'fk_marks_exams1')->references('id')->on('exams')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

}
