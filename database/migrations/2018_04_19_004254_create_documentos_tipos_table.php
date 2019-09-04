<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',90);
            $table->text('descripcion')->nullable();
            $table->string('pregunta')->nullable();
            $table->boolean('activo');
            $table->boolean('firmado');
            $table->string('acerca_de')->nullable();
            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
            $table->timestamps();
            $table->text('tooltip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos_tipos');
    }
}
