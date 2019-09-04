<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integradores', function (Blueprint $table) {
            $table->increments('id');
            
            
            $table->string('nombre_comercial', 100)->nullable()->default('text');
            $table->string('razon_social', 100)->nullable()->default('text');
            $table->string('rfc', 100)->nullable()->default('text');
            $table->string('pagina_internet', 100)->nullable()->default('text');
            $table->integer('anios_operando')->unsigned()->nullable();
            $table->boolean('activo')->nullable()->default(true);
            
            $table->string('nombre_socio')->nullable();
            $table->string('apellido_paterno_socio')->nullable();
            $table->string('apellido_materno_socio')->nullable();
            $table->boolean('aceptacion_buro')->nullable()->default(false);

            $table->enum('producto_principal',['Solar Fotovoltaico','Eficiencia energética','Iluminación','Aires acondicionados','Puertas','Ventanas','Impermeabilización','Aislamientos','Otro'])->nullable();
            $table->string('ventas_anuales')->nullable();

            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
            $table->integer('autorizado_por')->nullable();

            $table->dateTime('autorizado_at')->nullable()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integradores');
    }
}
