<?php

use App\Models\BookUser;
use App\Models\ReturnBook;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('school_year_id');
            $table->date('return_date');
            $table->integer('return_books_count')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        $book_users = BookUser::whereNotNull('back')->whereNotNull('school_year_id')->get();
        foreach($book_users as $item){
            ReturnBook::create(['book_id'=>$item->book_id,'user_id'=>$item->user_id,'return_date'=>$item->back, 'school_year_id'=>$item->school_year_id]);
        }
        Schema::table('book_users', function (Blueprint $table) {
            $table->dropColumn('back');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_books');

        Schema::table('book_users', function (Blueprint $table) {
            $table->date('back');
        });
    }
}
