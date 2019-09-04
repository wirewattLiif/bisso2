<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCotizacionDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_detalle', function (Blueprint $table) {
            $table->integer('estatus_id')->unsigned()->nullable();
            $table->foreign('estatus_id')->references('id')->on('cotizacion_detalle_estatus');            

            $table->date('fecha_preautorizacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizaciones_detalle', function (Blueprint $table) {
            $table->dropForeign('cotizaciones_detalle_estatus_id_foreign');
            $table->dropColumn('estatus_id');
        });
    }
}
