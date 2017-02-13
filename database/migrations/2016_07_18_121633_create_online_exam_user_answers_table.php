<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineExamUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_exam_user_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('online_exam_id');
            $table->foreign('online_exam_id', 'fk_online_exam_online_exam_id_foreign')
                ->references('id')->on('online_exams')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('online_exam_question_id');
            $table->foreign('online_exam_question_id', 'fk_online_exam_question_online_exam_user_answer_id_foreign')
                ->references('id')->on('online_exam_questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'fk_online_exam_user_answers_user_id_foreign')
                ->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('online_exam_answer_id');
            $table->double('points', 6, 2);
            $table->string('answer_text')->nullable();
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
            $table->dropForeign('fk_online_exam_online_exam_id_foreign');;
            $table->dropForeign('fk_online_exam_answer_online_exam_user_answer_id_foreign');
            $table->dropForeign('fk_online_exam_user_answers_user_id_foreign');
        });
        Schema::drop('online_exam_user_answers');
    }
}
