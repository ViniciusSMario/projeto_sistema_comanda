<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comandas_id')->unsigned();
            $table->decimal('valor_total', 10,2);
            $table->integer('tipo_pagamentos_id')->unsigned();

            $table->foreign('comandas_id')->references('id')->on('comandas');
            $table->foreign('tipo_pagamentos_id')->references('id')->on('tipo_pagamentos');
            $table->softDeletes();
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
        Schema::dropIfExists('fechamentos');
    }
}
