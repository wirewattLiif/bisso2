<?php

use Illuminate\Database\Seeder;

class SolicitudesEstatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'En revisión',
            'descripcion'=>'En revisión',
            'activo'=>1,
            'color'=>'#faab4f',
            'tooltip'=>'Un analista esta revisando tu solicitud y preautorizara tu crédito.'
        ]);

        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'Autorizada',
            'descripcion'=>'Autorizada',
            'activo'=>1,
            'color'=>'#08C394',
            'tooltip'=>'Tu crédito fue autorizado y	un analista estará en contacto contigo para recoger	el contrato	e iniciar el crédito.'
        ]);

        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'Rechazada',
            'descripcion'=>'Rechazada',
            'activo'=>1,
            'color'=>'#F99478',
            'tooltip'=>''
        ]);
        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'Pre Autorizada',
            'descripcion'=>'Pre Autorizada',
            'activo'=>1,
            'color'=>'#767676',
            'tooltip'=>'Tu crédito esta	preautorizado y	es necesario que cargues los documentos	necesarios dentro de la	plataforma para validar	tu información.'
        ]);
        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'Rev Documentos',
            'descripcion'=>'Rev Documentos',
            'activo'=>1,
            'color'=>'#A9A9A9',
            'tooltip'=>''
        ]);
        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'Creada',
            'descripcion'=>'Creada',
            'activo'=>1,
            'color'=>'#F29844',
            'tooltip'=>''
        ]);
        \Illuminate\Support\Facades\DB::table('solicitudes_estatus')->insert([
            'nombre'=>'Documentos de cierre firmados',
            'descripcion'=>'Documentos de cierre firmados',
            'activo'=>1,
            'color'=>'#F29844',
            'tooltip'=>''
        ]);
    }
}
