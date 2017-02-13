<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('fk_messages_users1');
            $table->dropForeign('fk_messages_users2');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('title', 'subject');
            $table->renameColumn('content', 'message');
            $table->renameColumn('user_id_receiver', 'to');
            $table->renameColumn('user_id_sender', 'from');
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
            $table->renameColumn('subject', 'title');
            $table->renameColumn('message', 'content');
            $table->renameColumn('to', 'user_id_receiver');
            $table->renameColumn('from', 'user_id_sender');
        });
    }
}
