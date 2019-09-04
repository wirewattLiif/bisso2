<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCotizacionesDetallePrecioListaPagoInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_detalle', function (Blueprint $table) {
            $table->float('precio_lista', 11, 2)->nullable()->default(0)->after('mensualidad');
            $table->float('pago_inicial', 11, 2)->nullable()->default(0)->after('precio_lista');
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
           $table->dropColumn('precio_lista');
           $table->dropColumn('pago_inicial');
        });
    }
}
