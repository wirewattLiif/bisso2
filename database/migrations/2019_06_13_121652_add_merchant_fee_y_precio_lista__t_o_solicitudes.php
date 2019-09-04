<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMerchantFeeYPrecioListaTOSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->float('merchant_fee', 11, 2)->nullable()->default(0)->after('enganche');
            $table->float('precio_lista', 11, 2)->nullable()->default(0)->after('enganche');
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
           $table->dropColumn('merchant_fee');
           $table->dropColumn('precio_lista');
        });
    }
}
