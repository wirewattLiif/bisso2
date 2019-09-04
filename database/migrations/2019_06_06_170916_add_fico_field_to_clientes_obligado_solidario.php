<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFicoFieldToClientesObligadoSolidario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->decimal('fico_score', 11, 2)->nullable()->after('ingresos_anuales');
            $table->decimal('deuda_mensual', 11, 2)->nullable()->after('fico_score');
        });


        Schema::table('obligados_solidarios', function (Blueprint $table) {
            $table->decimal('fico_score', 11, 2)->nullable()->default(0)->after('salario_mensual');
            $table->decimal('deuda_mensual', 11, 2)->nullable()->default(0)->after('fico_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('fico_score');
            $table->dropColumn('deuda_mensual');            
        });


        Schema::table('obligados_solidarios', function (Blueprint $table) {
            $table->dropColumn('fico_score');
            $table->dropColumn('deuda_mensual');
        });
    }
}
