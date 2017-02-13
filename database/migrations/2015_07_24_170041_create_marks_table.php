<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('exam_id');
            $table->foreign('exam_id', 'fk_marks_exams1')->references('id')->on('exams')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('mark_type_id');
            $table->foreign('mark_type_id', 'fk_marks_mark_types1')->references('id')->on('mark_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('semester_id');
            $table->foreign('semester_id', 'fk_marks_semesters1')->references('id')->on('semesters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('student_id');
            $table->foreign('student_id', 'fk_marks_students1')->references('id')->on('students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id', 'fk_marks_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('subject_id');
            $table->foreign('subject_id', 'fk_marks_subjects1')->references('id')->on('subjects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->integer('mark');
            $table->date('date');
            $table->text('comment');
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
        Schema::table('marks', function (Blueprint $table) {
            $table->dropForeign('fk_marks_exams1');
            $table->dropForeign('fk_marks_mark_types1');
            $table->dropForeign('fk_marks_semester1');
            $table->dropForeign('fk_marks_students1');
            $table->dropForeign('fk_marks_subjects1');
            $table->dropForeign('fk_marks_users1');
        });
        Schema::drop('marks');
    }

}
