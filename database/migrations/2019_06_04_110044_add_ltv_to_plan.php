<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLtvToPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->double('ltv', 6, 2)->nullable()->after('dti_pre')->default(0);
            $table->double('enganche_min',11, 2)->nullable()->default(0)->after('ltv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->dropColumn('ltv');
            $table->dropColumn('enganche_min');
        });
    }
}
