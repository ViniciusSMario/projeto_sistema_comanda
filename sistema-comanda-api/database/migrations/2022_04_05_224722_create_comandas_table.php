<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comandas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mesas_id')->unsigned();
            $table->string('nome');
            $table->string('celular');
            $table->enum('status', ['aberta', 'fechada'])->default('aberta');

            $table->foreign('mesas_id')->references('id')->on('mesas');
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
        Schema::dropIfExists('comandas');
    }
}
