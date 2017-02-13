<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faq_categories', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
		});

		Schema::create('faqs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('faq_category_id');
			$table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('slug');
			$table->text('content');
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
		Schema::drop('faqs');

		Schema::drop('faq_categories');
	}

}
