<?php

use App\Models\BookUser;
use App\Models\GetBook;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('get_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('school_year_id');
            $table->date('get_date');
            $table->integer('get_books_count')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        $book_users = BookUser::whereNotNull('get')->whereNotNull('school_year_id')->get();
        foreach($book_users as $item){
            GetBook::create(['book_id'=>$item->book_id,'user_id'=>$item->user_id,'get_date'=>$item->get, 'school_year_id'=>$item->school_year_id]);
        }
        Schema::table('book_users', function (Blueprint $table) {
            $table->dropColumn('get');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_books');

        Schema::table('book_users', function (Blueprint $table) {
            $table->date('get');
        });
    }
}
