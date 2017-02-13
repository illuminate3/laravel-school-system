<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsIntoBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('option_id_category')->nullable()->after('title');
            if(!Schema::hasColumn('books','price')) {
                $table->double('price')->nullable()->after('option_id_category');
            }
            $table->string('isbn')->nullable()->after('price');
            $table->integer('option_id_borrowing_period')->nullable()->after('isbn');
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
            $table->dropColumn('option_id_category');
            $table->dropColumn('price');
            $table->dropColumn('isbn');
            $table->dropColumn('option_id_period');
        });
    }
}
