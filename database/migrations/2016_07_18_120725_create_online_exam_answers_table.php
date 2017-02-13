<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_exam_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('online_exam_question_id')->nullable();
            $table->foreign('online_exam_question_id', 'fk_online_question_online_exam_id_foreign')->references('id')->on('online_exam_questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('title');
            $table->boolean('correct_answer')->default(0);
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
        Schema::table('online_exam_answers', function (Blueprint $table) {
            $table->dropForeign('fk_online_exam_online_exam_question_id_foreign');
        });

        Schema::drop('online_exam_answers');
    }
}
