<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nombre'=>'DEV',
            'email'=>'hvillasana@bisso.mx',
            'password'=>bcrypt('123456789'),
            'grupo_id'=>1,
            'creado_por'=>1,
            'cliente_id'=>null,
            'modificado_por'=>null
        ]);
    }
}
