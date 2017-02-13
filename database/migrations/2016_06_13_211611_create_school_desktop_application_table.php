<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDesktopApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_desktop_applications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->foreign('school_id', 'school_desktop_application_schools_id_foreign')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('auth_id');
            $table->string('auth_secure');
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
        Schema::table('school_desktop_applications', function (Blueprint $table) {
            $table->dropForeign('school_desktop_application_schools_id_foreign');
        });

        Schema::drop('school_desktop_applications');
    }
}
