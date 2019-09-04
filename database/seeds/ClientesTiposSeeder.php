<?php

use Illuminate\Database\Seeder;

class ClientesTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('clientes_tipos')->truncate();
        DB::unprepared(file_get_contents(database_path('sqls/clientes_tipos.sql')));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
