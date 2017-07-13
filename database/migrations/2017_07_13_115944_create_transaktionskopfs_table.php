<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaktionskopfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaktionskopfs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kunde_id')->foreign('kunde_id')->references('id')->on('kundes')->nullable();
            $table->integer('store_id')->foreign('store_id')->references('id')->on('stores')->nullable();
            $table->integer('mitarbeiter_id')->foreign('mitarbeiter_id')->references('id')->on('mitarbeiters')->nullable();
            $table->string('shipping')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->dateTime('date')->nullable();         
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
        Schema::dropIfExists('transaktionskopfs');
    }
}
