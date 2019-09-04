<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRazonSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('razones_sociales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('representante_legal')->nullable();

            $table->string('logo')->nullable();
            $table->string('encname')->nullable();
            $table->string('filepath')->nullable();

            $table->string('calle',50)->nullable();
            $table->string('numero_ext',15)->nullable();
            $table->string('numero_int',15)->nullable();
            $table->string('colonia',100)->nullable();
            $table->integer('estado_id')->references('id')->on('estados');
            $table->integer('municipio_id')->references('id')->on('municipios');
            $table->string('cp',11)->nullable();
            $table->boolean('activo')->nullable();

            $table->string('telefono',20)->nullable();
            $table->string('correo',90)->nullable();
            $table->string('web',90)->nullable();
            $table->string('banco',90)->nullable();
            $table->string('beneficiario')->nullable();
            $table->string('cuenta',90)->nullable();
            $table->string('clabe',90)->nullable();
            $table->string('rfc_beneficiario',90)->nullable();
            $table->decimal('interes_moratorio',11,2)->nullable();
            $table->decimal('gastos_administrativos',11,2)->nullable();


            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
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
        Schema::dropIfExists('razones_sociales');
    }
}
