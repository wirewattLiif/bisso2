<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToIntegradores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('integradores', function (Blueprint $table) {
           $table->enum('tipo_persona', ['Persona Física', 'Persona Física con Actividad Empresarial','Persona Moral','Otro'])->nullable()->after('ventas_anuales');
           $table->enum('financiamientos_ofrecidos', ['FIDE', 'Tarjeta de Crédito','Otro'])->nullable()->after('tipo_persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('integradores', function (Blueprint $table) {
            
            $table->dropColumn('tipo_persona');
            $table->dropColumn('financiamientos_ofrecidos');
        });
    }
}
