<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('techlog');
            $table->unsignedBigInteger('aircraft_id');
            $table->unsignedBigInteger('departure');
            $table->unsignedBigInteger('destination');
            $table->time('off_time');
            $table->time('on_time');
            $table->integer('block_time');
            $table->unsignedBigInteger('pic');
            $table->unsignedBigInteger('sic');
            $table->string('eob1')->default('');
            $table->string('eob2')->default('');
            $table->text('pax');
            $table->text('remarks');
            $table->timestamps();
            
            $table->foreign('aircraft_id')->references('id')->on('aircrafts');
            $table->foreign('departure')->references('id')->on('airports');
            $table->foreign('destination')->references('id')->on('airports');
            $table->foreign('pic')->references('id')->on('users');
            $table->foreign('sic')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_logs');
    }
}
