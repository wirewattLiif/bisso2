<?php

use Illuminate\Database\Seeder;

class razones_sociales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('razones_sociales')->truncate();
        DB::unprepared(file_get_contents(database_path('sqls/razones_sociales.sql')));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}