<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTiposDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_tipos_documentos', function (Blueprint $table) {
            $table->unsignedInteger('cliente_tipo_id');
            $table->foreign('cliente_tipo_id')->references('id')->on('clientes_tipos');
            $table->unsignedInteger('documento_tipo_id');
            $table->foreign('documento_tipo_id')->references('id')->on('documentos_tipos');
            $table->boolean('obligatorio');
            $table->boolean('activo');
            $table->integer('creado_por')->nullable();
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
        Schema::dropIfExists('clientes_tipos_documentos');
    }
}
