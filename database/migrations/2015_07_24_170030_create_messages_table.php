<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('message_id')->nullable();
            $table->boolean('read')->default(0);
            $table->string('title');
            $table->text('content');
            $table->unsignedInteger('user_id_receiver');
            $table->foreign('user_id_receiver', 'fk_messages_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->unsignedInteger('user_id_sender');
            $table->foreign('user_id_sender', 'fk_messages_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->dateTime('deleted_at_sender')->nullable();
            $table->dateTime('deleted_at_receiver')->nullable();
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('fk_messages_users1');
            $table->dropForeign('fk_messages_users2');
        });
        Schema::drop('messages');
    }

}
