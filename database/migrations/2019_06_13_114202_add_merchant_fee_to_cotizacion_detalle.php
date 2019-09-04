<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMerchantFeeToCotizacionDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_detalle', function (Blueprint $table) {
            $table->float('merchant_fee', 11, 2)->nullable()->default(0)->after('mensualidad');            
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
           $table->dropColumn('merchant_fee');
        });
    }
}
