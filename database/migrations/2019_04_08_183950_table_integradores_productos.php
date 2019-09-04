<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableIntegradoresProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integradores_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('integrador_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            
            $table->foreign('integrador_id')->references('id')->on('integradores')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integradores_productos');
    }
}
