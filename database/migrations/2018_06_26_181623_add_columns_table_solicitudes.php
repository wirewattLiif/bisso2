<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function($table) {
            $table->decimal('interes_anual',8,2)->nullable();
            $table->decimal('porcentaje_iva',8,2)->nullable();
            $table->decimal('descuento_opcion_compra',8,2)->nullable();
            $table->decimal('porcentaje_pago_valor_residual',8,2)->nullable();
            $table->decimal('escalador',8,2)->nullable();

            $table->decimal('porcentaje_comision_por_apertura',8,2)->nullable();
            $table->decimal('comision_por_apertura',8,2)->nullable();
            $table->decimal('costo_anual_seguro',8,2)->nullable();
            $table->decimal('pago_inicial',8,2)->nullable();

            $table->decimal('deuda_mensual',8,2)->nullable();
            $table->decimal('fico',8,2)->nullable();

            $table->date('primer_fecha_vencimiento')->nullable();

            $table->text('descripcion_de_bienes')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
