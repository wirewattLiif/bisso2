<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocumentosFaltantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('ine_atras_file')->nullable()->after('hoja_buro_path');
            $table->string('ine_atras_path')->nullable()->after('ine_atras_file');
            $table->string('foto_buro_file')->nullable()->after('ine_atras_path');
            $table->string('foto_buro_path')->nullable()->after('foto_buro_file');
        });

        Schema::table('obligados_solidarios', function (Blueprint $table) {
            $table->string('ine_atras_file')->nullable()->after('hoja_buro_path');
            $table->string('ine_atras_path')->nullable()->after('ine_atras_file');
            $table->string('foto_buro_file')->nullable()->after('ine_atras_path');
            $table->string('foto_buro_path')->nullable()->after('foto_buro_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('ine_atras_file');
            $table->dropColumn('ine_atras_path');
            $table->dropColumn('foto_buro_file');
            $table->dropColumn('foto_buro_path');
        });

        Schema::table('obligados_solidarios', function (Blueprint $table) {
            $table->dropColumn('ine_atras_file');
            $table->dropColumn('ine_atras_path');
            $table->dropColumn('foto_buro_file');
            $table->dropColumn('foto_buro_path');
        });
    }
}
