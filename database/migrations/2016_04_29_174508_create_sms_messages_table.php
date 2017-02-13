<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('text');
            $table->string('number');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'sms_messages_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('user_id_sender');
            $table->foreign('user_id', 'sms_messages_user_id_sender_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::table('sms_messages', function (Blueprint $table) {
            $table->dropForeign('sms_messages_user_id_foreign');
            $table->dropForeign('sms_messages_user_id_sender_foreign');
        });

        Schema::drop('sms_messages');
    }
}
