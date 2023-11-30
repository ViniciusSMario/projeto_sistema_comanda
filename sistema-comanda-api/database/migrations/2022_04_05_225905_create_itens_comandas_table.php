<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensComandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_comandas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comandas_id')->unsigned();
            $table->integer('produtos_id')->unsigned();
            $table->integer('quantidade');
            $table->decimal('valor', 10,2);
            $table->enum('status', ['na_cozinha', 'finalizado'])->default('na_cozinha');
            $table->foreign('comandas_id')->references('id')->on('comandas');
            $table->foreign('produtos_id')->references('id')->on('produtos');
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
        Schema::dropIfExists('itens_comandas');
    }
}
