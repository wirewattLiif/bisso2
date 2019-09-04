<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cotizacion_id');
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade');                        

            $table->unsignedInteger('plan_id')->nullable();
            $table->decimal('monto_solicitado', 11, 2)->nullable();
            $table->decimal('monto_financiar', 11, 2)->nullable();
            $table->tinyInteger('plazo_financiar')->nullable();
            $table->decimal('enganche',11,2)->nullable();
            $table->decimal('mensualidad', 11, 2)->nullable();
            
            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
            $table->integer('autorizado_por')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones_detalle');
    }
}
