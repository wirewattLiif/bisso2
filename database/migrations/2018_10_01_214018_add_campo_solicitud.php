<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampoSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes',function(Blueprint $table){
            $table->integer('plan_id')->nullable()->after('estatus_id');
            $table->boolean('aplica_costo_anual_seguro')->nullable()->after('escalador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes',function(Blueprint $table){
            $table->dropColumn('plan_id');
            $table->dropColumn('aplica_costo_anual_seguro');
        });
    }
}
