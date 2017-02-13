<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefixIntoSchoolsForStudentAndVisitorsCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('student_card_prefix')->nullable()->after('phone');
            $table->string('student_card_background')->nullable()->after('student_card_prefix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('student_card_prefix');
            $table->dropColumn('student_card_background');
        });
    }
}
