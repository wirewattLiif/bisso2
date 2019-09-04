<?php

use Illuminate\Database\Seeder;

class PlanesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('clientes_tipos_documentos')->truncate();
        DB::unprepared(file_get_contents(database_path('sqls/planes.sql')));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
