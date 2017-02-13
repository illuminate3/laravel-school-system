<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineExamQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_exam_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('online_exam_id')->nullable();
            $table->foreign('online_exam_id', 'fk_online_exam_online_exam_question_id_foreign')->references('id')->on('online_exams')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('title');
            $table->text('description');
            $table->integer('answers_type');
            $table->double('points', 6, 2);
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
        Schema::table('online_exam_questions', function (Blueprint $table) {
            $table->dropForeign('fk_online_exam_online_exam_question_id_foreign');
        });

        Schema::drop('online_exam_questions');
    }
}
