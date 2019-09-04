<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCoaplicanteToObligadosSolidarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obligados_solidarios', function (Blueprint $table) {
            $table->string('ine_file')->nullable()->after('rfc');
            $table->string('ine_path')->nullable()->after('ine_file');
            
            $table->string('hoja_buro_file')->nullable()->after('ine_path');
            $table->string('hoja_buro_path')->nullable()->after('hoja_buro_file');

            $table->double('salario_mensual', 11, 2)->nullable()->after('hoja_buro_path');
            $table->string('email', 100)->nullable()->after('salario_mensual');
            $table->string('telefono_movil',30)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obligados_solidarios', function (Blueprint $table) {
            $table->dropColumn('ine_file');
            $table->dropColumn('ine_path');
            $table->dropColumn('hoja_buro_file');
            $table->dropColumn('hoja_buro_path');
            $table->dropColumn('salario_mensual');
            $table->dropColumn('email');
            $table->dropColumn('telefono_movil');
        });
    }
}
