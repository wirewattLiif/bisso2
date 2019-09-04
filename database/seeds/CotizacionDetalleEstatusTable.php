<?php

use Illuminate\Database\Seeder;

class CotizacionDetalleEstatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('cotizacion_detalle_estatus')->insert([
            'nombre'=>'Creado',            
            'activo'=>true
        ]);

        \Illuminate\Support\Facades\DB::table('cotizacion_detalle_estatus')->insert([
            'nombre'=>'Pre-autorizado',            
            'activo'=>true
        ]);

        \Illuminate\Support\Facades\DB::table('cotizacion_detalle_estatus')->insert([
            'nombre'=>'Autorizado',            
            'activo'=>true
        ]);
    }
}
