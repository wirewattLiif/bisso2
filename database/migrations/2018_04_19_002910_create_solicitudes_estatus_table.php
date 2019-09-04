<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesEstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_estatus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',90);
            $table->text('descripcion')->nullable();
            $table->boolean('activo');
            $table->unsignedInteger('creado_por')->nullable();
            $table->unsignedInteger('modificado_por')->nullable();
            $table->timestamps();
            $table->string('color',9)->nullable();
            $table->string('tooltip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes_estatus');
    }
}
