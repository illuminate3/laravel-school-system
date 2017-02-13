<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveFeedbackTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropForeign('feedbacks_feedback_type_id_foreign');

        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn('feedback_type_id');

        });

        Schema::table('feedbacks', function (Blueprint $table) {
            $table->string('feedback_type')->nullable()->after('user_id');

        });
        Schema::drop('feedback_types');
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn('feedback_type');

        });
        Schema::create('feedback_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->unsignedInteger('feedback_type_id')->nullable();
            $table->foreign('feedback_type_id')->references('id')->on('feedback_types')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

}
