<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBooksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('subject_id')->nullable();
            $table->foreign('subject_id', 'fk_books_subjects1')->references('id')->on('subjects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('title');
            $table->string('author');
            $table->string('year');
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
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign('fk_books_subjects1');
        });
        Schema::drop('books');
    }

}
