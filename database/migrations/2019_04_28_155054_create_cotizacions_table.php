<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 120)->nullable();
            $table->unsignedInteger('integrador_id')->nullable();
            $table->foreign('integrador_id')->references('id')->on('integradores')->onDelete('cascade');
            $table->boolean('requiere_coaplicante')->nullable()->default(false);
            $table->boolean('terminada')->nullable()->default(false);
            
            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
            $table->integer('autorizado_por')->nullable();

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
        Schema::dropIfExists('cotizaciones');
    }
}
