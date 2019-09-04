<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanesAddFieldsCostoAnualComisionApertura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planes',function(Blueprint $table){
            $table->decimal('comision_por_apertura',11,2)->nullable()->after('plazo');
            $table->boolean('costo_anual_seguro')->nullable()->after('comision_por_apertura');

            $table->boolean('personalizado')->nullable()->default(false)->after('costo_anual_seguro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planes',function(Blueprint $table){
            $table->dropColumn('comision_por_apertura');
            $table->dropColumn('costo_anual_seguro');
            $table->dropColumn('personalizado');
        });
    }
}
