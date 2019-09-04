<?php

use Illuminate\Database\Seeder;

class DocumentosTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('documentos_tipos')->truncate();
        DB::unprepared(file_get_contents(database_path('sqls/documentos_tipos.sql')));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
