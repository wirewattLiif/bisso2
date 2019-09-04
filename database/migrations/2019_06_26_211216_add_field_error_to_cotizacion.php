<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldErrorToCotizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_detalle', function (Blueprint $table) {
            $table->boolean('error_ws')->nullable(); //Indica que ya se intento validar con CC y debemos mostrarla al admin disponible para que el pueda preautorizarla si se lo piden
            $table->string('msj_error_ws')->nullable();
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
           $table->dropColumn('error_ws');
           $table->dropColumn('msj_error_ws');
        });
    }
}
