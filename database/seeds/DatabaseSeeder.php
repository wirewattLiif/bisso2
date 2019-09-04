<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
            GruposTableSeeder::class,
            SolicitudesEstatusTableSeeder::class,
            UsersTableSeeder::class,
            GirosComercialesSeeder::class,
            InmueblesSeeder::class,
            EstadosMunicipiosSeeder::class,
            DocumentosTiposSeeder::class,
            ClientesTiposSeeder::class,
            ClientesTiposDocumentosSeeder::class,
            ConfiguracionesTableSeeder::class,
            PlanesSeeder::class,
            razones_sociales::class,
            TipoProyectosSeeder::class
         ]);
        
    }
}
