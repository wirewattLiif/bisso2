<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomiciliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');



            $table->string('calle')->nullable();
            $table->string('numero_ext',20)->nullable();
            $table->string('numero_int',20)->nullable();
            $table->string('colonia')->nullable();
            $table->string('ciudad')->nullable();
            $table->unsignedInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->unsignedInteger('municipio_id');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->string('cp',6)->nullable();
            $table->boolean('fiscal');
            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
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
        Schema::dropIfExists('domicilios');
    }
}
