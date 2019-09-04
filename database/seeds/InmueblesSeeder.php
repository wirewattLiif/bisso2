<?php

use Illuminate\Database\Seeder;

class InmueblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('inmuebles')->insert([
            ['nombre'=>'Casa','descripcion'=>''],
            ['nombre'=>'Negocio','descripcion'=>''],
            ['nombre'=>'Departamento','descripcion'=>''],
            ['nombre'=>'Rancho','descripcion'=>''],
            ['nombre'=>'Otro','descripcion'=>'']
        ]);
    }
}
