<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduktsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->float('price')->nullable();
            $table->string('producer')->nullable();
            $table->string('description')->nullable();
            $table->float('tax')->nullable();
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
        Schema::dropIfExists('produkts');
    }
}
