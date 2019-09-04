<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldSolicitudesCotizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->integer('preautorizacion_id')->unsigned()->nullable()->after('razon_social_id');
            $table->foreign('preautorizacion_id')->references('id')->on('cotizaciones_detalle');

            $table->integer('integrador_id')->unsigned()->nullable()->after('preautorizacion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropForeign('solicitudes_preautorizacion_id_foreign');
            $table->dropColumn('preautorizacion_id');

            $table->dropColumn('integrador_id');
        });
    }
}
