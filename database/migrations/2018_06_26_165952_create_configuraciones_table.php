<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('interes_anual',8,2);
            $table->decimal('iva',8,2);
            $table->decimal('descuento_opcion_compra',8,2);
            $table->decimal('porcentaje_pago_valor_residual',8,2);
            $table->decimal('escalador',8,2);
            $table->decimal('comision_por_apertura',8,2);
            $table->decimal('monto_min_financiar',8,2);
            $table->decimal('interes_ordinario',8,2);
            $table->decimal('interes_moratorio',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuraciones');
    }
}
