<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaktionspositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaktionspositions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produkt_id')->foreign('produkt_id')->references('id')->on('produkts')->nullable();
            $table->integer('transaktionskopf_id')->foreign('transaktionskopf_id')->references('id')->on('transaktionskopfs')->nullable();
            $table->integer('amount')->nullable();
            $table->float('discount')->nullable();
            $table->float('net_price')->nullable();
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
        Schema::dropIfExists('transaktionspositions');
    }
}
