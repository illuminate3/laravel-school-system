<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMorePayField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status')->nullable()->after('description');
            $table->string('paykey')->nullable()->after('status');
            $table->string('correlation_id')->nullable()->after('paykey');
            $table->string('timestamp')->nullable()->after('correlation_id');
            $table->string('ack')->nullable()->after('timestamp');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('paykey');
            $table->dropColumn('correlation_id');
            $table->dropColumn('timestamp');
            $table->dropColumn('ack');
        });
    }

}
