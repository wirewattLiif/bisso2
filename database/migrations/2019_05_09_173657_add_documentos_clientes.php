<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentosClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('ine_file')->nullable();
            $table->string('ine_path')->nullable();
            
            $table->string('hoja_buro_file')->nullable();
            $table->string('hoja_buro_path')->nullable();
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
            $table->dropColumn('ine_file');
            $table->dropColumn('ine_path');
            $table->dropColumn('hoja_buro_file');
            $table->dropColumn('hoja_buro_path');
        });
    }
}
