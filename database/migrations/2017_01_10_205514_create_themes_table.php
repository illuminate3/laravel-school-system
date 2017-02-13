<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('menu_bg_color');
            $table->string('menu_active_bg_color');
            $table->string('menu_active_border_right_color');
            $table->string('menu_color');
            $table->string('menu_active_color');
            $table->string('frontend_menu_bg_color');
            $table->string('frontend_bg_color');
            $table->string('frontend_text_color');
            $table->string('frontend_link_color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
