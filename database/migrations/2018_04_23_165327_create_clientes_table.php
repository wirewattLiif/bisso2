<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cliente_tipo_id')->nullable();
            $table->foreign('cliente_tipo_id')->references('id')->on('clientes_tipos');

            $table->enum('persona_tipo',['fisica','moral'])->nullable();

            $table->unsignedInteger('giro_comercial_id')->nullable();

            $table->unsignedInteger('inmueble_id')->nullable();

            $table->string('nombre');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('telefono_movil')->nullable();
            $table->string('telefono_fijo')->nullable();
            $table->string('correo',90)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->unsignedInteger('estado_nacimiento_id');
            $table->foreign('estado_nacimiento_id')->references('id')->on('estados');
            $table->unsignedInteger('ciudad_nacimiento_id')->nullable();
            $table->foreign('ciudad_nacimiento_id')->references('id')->on('municipios');
            $table->enum('sexo',['Masculino','Femenino']);
            $table->string('curp',20)->nullable();
            $table->string('rfc',30)->nullable();

            $table->boolean('dueno_casa')->nullable();
            $table->boolean('trabaja')->nullable();
            $table->string('nombre_empresa')->nullable();
            $table->string('puesto')->nullable();
            $table->string('industria')->nullable();
            $table->string('telefono_oficina')->nullable();
            $table->decimal('salario_mensual',11,2)->nullable();
            $table->boolean('pago_banco')->nullable();
            $table->decimal('salario_familiar',11,2)->nullable();
            $table->integer('dependientes')->nullable();
            $table->boolean('tarjeta_credito_titular')->nullable();
            $table->boolean('credito_hipotecario')->nullable();
            $table->boolean('credito_automotriz')->nullable();
            $table->enum('historial_credito',['No tengo historial','No se','Malo','Regular','Bueno'])->nullable();
            $table->smallInteger('ultimos_digitos')->nullable();

            $table->string('rfc_facturar')->nullable();
            $table->decimal('facturacion_anual',11,2)->nullable();
            $table->string('contrasenia_sat')->nullable();

            $table->string('uuid',40)->nullable();
            $table->integer('creado_por')->nullable();
            $table->integer('modificado_por')->nullable();
            $table->boolean('registro_completo')->default(0);



            $table->timestamps();
            $table->softDeletes();


            $table->string('obligado_solidario_nombre')->nullable();
            $table->string('obligado_solidario_fecha_nacimiento')->nullable();
            $table->string('obligado_solidario_direccion')->nullable();
            $table->string('rentero_nombre')->nullable();
            $table->string('rentero_folio_predial',30)->nullable();
            $table->decimal('ingresos_anuales',11,2)->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_cliente_id_foreign');
        });

        Schema::dropIfExists('clientes');
    }
}
