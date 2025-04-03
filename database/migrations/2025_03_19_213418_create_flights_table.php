<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('departure_city')->default('Vilnius');
            $table->unsignedBigInteger('destination_id');
            $table->string('airline')->nullable();
            $table->string('flight_duration')->nullable();
            $table->timestamps();

            $table->foreign('destination_id')
                  ->references('id')->on('destinations')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
