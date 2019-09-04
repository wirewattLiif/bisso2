<?php

use Illuminate\Database\Seeder;

class ConfiguracionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('configuraciones')->insert([
            'interes_anual'=>13.00,
            'iva'=>16.00,
            'descuento_opcion_compra'=>3.50,
            'porcentaje_pago_valor_residual'=>7.00,
            'escalador'=>4.00,
            'comision_por_apertura'=>5,
            'monto_min_financiar'=>40000,
            'interes_ordinario'=>21,
            'interes_moratorio'=>40,
        ]);
    }
}
