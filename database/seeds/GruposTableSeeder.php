<?php

use Illuminate\Database\Seeder;

class GruposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('grupos')->insert([
            'nombre'=>'Dev',
            'descripcion'=>'Dev',
            'home_page'=>'/admin/solicitudes'
        ]);

        \Illuminate\Support\Facades\DB::table('grupos')->insert([
            'nombre'=>'Admin',
            'descripcion'=>'Admin',
            'home_page'=>'/admin/solicitudes'
        ]);

        \Illuminate\Support\Facades\DB::table('grupos')->insert([
            'nombre'=>'Atención cliente',
            'descripcion'=>'Atención cliente',
            'home_page'=>'/admin/solicitudes'
        ]);

        \Illuminate\Support\Facades\DB::table('grupos')->insert([
            'nombre'=>'Analista',
            'descripcion'=>'Analista',
            'home_page'=>'/admin/solicitudes'
        ]);

        \Illuminate\Support\Facades\DB::table('grupos')->insert([
            'nombre'=>'Cliente',
            'descripcion'=>'Cliente',
            'home_page'=>'/solicitudes'
        ]);

        \Illuminate\Support\Facades\DB::table('grupos')->insert([
            'nombre'=>'Integradores',
            'descripcion'=>'Integradores',
            'home_page'=>'/solicitudes'
        ]);
    }
}
