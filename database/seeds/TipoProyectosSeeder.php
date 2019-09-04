<?php

use Illuminate\Database\Seeder;

class TipoProyectosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('tipo_proyectos')->insert([
            'nombre'=>'Solar Fotovolatico'
        ]);
        \Illuminate\Support\Facades\DB::table('tipo_proyectos')->insert([
            'nombre'=>'Refrigeracion'
        ]);
        \Illuminate\Support\Facades\DB::table('tipo_proyectos')->insert([
            'nombre'=>'AC'
        ]);
        \Illuminate\Support\Facades\DB::table('tipo_proyectos')->insert([
            'nombre'=>'Iluminación'
        ]);
        \Illuminate\Support\Facades\DB::table('tipo_proyectos')->insert([
            'nombre'=>'Multiples'
        ]);
        \Illuminate\Support\Facades\DB::table('tipo_proyectos')->insert([
            'nombre'=>'Otro'
        ]);
    }
}
