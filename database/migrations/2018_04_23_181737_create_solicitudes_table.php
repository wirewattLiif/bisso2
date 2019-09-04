<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedInteger('estatus_id');
            $table->foreign('estatus_id')->references('id')->on('solicitudes_estatus');
            $table->string('folio',11)->nullable();

            $table->tinyInteger('total_paneles')->nullable();
            $table->decimal('capacidad_paneles',11,2)->nullable();
            $table->decimal('capacidad_sistema',11,2)->nullable();

            $table->decimal('cfe_promedio',11,2)->nullable();
            $table->decimal('ahorros_proyectados_mes',11,2)->nullable();
            $table->string('empresa_instaladora_solar')->nullable();
            $table->string('contacto_instaladora')->nullable();
            $table->date('fecha_instalacion_tentativa' )->nullable();
            $table->decimal('precio_sistema',11,2);
            $table->decimal('monto_financiar',11,2)->nullable();
            $table->tinyInteger('plazo_financiar')->nullable();
            $table->decimal('enganche',11,2)->nullable();

            $table->date('fecha_preautorizada')->nullable();
            $table->date('fecha_rev_docs')->nullable();
            $table->date('fecha_autorizada')->nullable();
            $table->date('fecha_cancelada')->nullable();
            $table->date('fecha_rechazada')->nullable();

            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE solicitudes AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
