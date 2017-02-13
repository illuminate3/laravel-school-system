<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransportationRouteTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportation_route', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('transportation_id');
            $table->foreign('transportation_id', 'fk_transportation_route_transportations1')->references('id')->on('transportations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('name')->nullable();
            $table->string('lat');
            $table->string('lang');
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
        Schema::table('transportation_route', function (Blueprint $table) {
            $table->dropForeign('fk_transportation_route_transportations1');
        });
        Schema::drop('transportation_route');
    }

}
