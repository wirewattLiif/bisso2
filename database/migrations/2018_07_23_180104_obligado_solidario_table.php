<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObligadoSolidarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        #//Descomentar cuando exista el registro en la tabla de migrations
        /*Schema::create('obligados_solidarios', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();

            $table->date('fecha_nacimiento')->nullable();

            $table->unsignedInteger('estado_nacimiento_id');
            $table->foreign('estado_nacimiento_id')->references('id')->on('estados');

            $table->enum('sexo',['Masculino','Femenino']);
            $table->string('curp',20)->nullable();
            $table->string('rfc',30)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });*/

        Schema::table('clientes',function(Blueprint $table){
            $table->dropColumn('obligado_solidario_nombre');
            $table->dropColumn('obligado_solidario_fecha_nacimiento');
            $table->dropColumn('obligado_solidario_direccion');
        });

        /*Schema::table('domicilios',function(Blueprint $table){
            $table->unsignedInteger('obligado_id')->nullable()->after('cliente_id');
            $table->foreign('obligado_id')->references('id')->on('obligados_solidarios');
        });*/




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domicilios',function(Blueprint $table){
            $table->dropForeign(['obligado_id']);
            $table->dropColumn('obligado_id');

        });

        Schema::dropIfExists('obligados_solidarios');
    }
}
