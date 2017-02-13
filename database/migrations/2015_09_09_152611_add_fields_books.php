<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsBooks extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('internal')->nullable()->after('id');
            $table->string('publisher')->nullable()->after('title');
            $table->string('version')->nullable()->after('publisher');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('internal');
            $table->dropColumn('publisher');
            $table->dropColumn('version');
        });
    }

}
