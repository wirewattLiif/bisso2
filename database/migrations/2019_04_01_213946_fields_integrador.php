<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FieldsIntegrador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('integrador_id')->unsigned()->nullable()->after('cliente_id');
            $table->string('phone', 30)->nullable()->after('integrador_id');
            $table->boolean('active')->nullable()->after('phone')->default(1);
        });

        Schema::table('domicilios', function (Blueprint $table) {
            $table->integer('integrador_id')->unsigned()->nullable()->after('obligado_id');
            $table->integer('socio_id')->unsigned()->nullable()->after('integrador_id');
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
           $table->dropColumn('integrador_id');
           $table->dropColumn('phone');
           $table->dropColumn('active');
        });

        Schema::table('domicilios', function (Blueprint $table) {
            $table->dropColumn('integrador_id');
            $table->dropColumn('socio_id');
        });
    }
}
