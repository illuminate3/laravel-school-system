<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExamAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_attendances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('comment')->nullable();
            $table->unsignedInteger('option_id');
            $table->unsignedInteger('student_id');
            $table->foreign('student_id', 'exam_attendances_student_id_foreign')->references('id')->on('students')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('exam_id');
            $table->foreign('exam_id', 'exam_attendances_exam_id_foreign')->references('id')->on('exams')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::table('exam_attendances', function (Blueprint $table) {
            $table->dropForeign('exam_attendances_student_id_foreign');
            $table->dropForeign('exam_attendances_exam_id_foreign');
        });
        Schema::drop('exam_attendances');
    }
}
