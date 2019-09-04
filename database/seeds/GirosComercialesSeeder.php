<?php

use Illuminate\Database\Seeder;

class GirosComercialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('giros_comerciales')->insert([
            ['nombre'=>'Comercializadora', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Taller mecánico', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Maquiladora', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Servicios Jurídicos', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Servicios Administrativos', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Servicios Contables', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Constructora', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Farmacia', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Productora', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Manufactura', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Seguridad y Vigilancia', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Limpieza', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Restaurant', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Escuela', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Agricultura', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Ganaderia', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Consultoria', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Transporte', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Desarrollo de Software', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Publicidad', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Mercadotecnia', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Diseño Gráfico', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Arquitectura', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Decoración', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Mueblería', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Renta de Maquinaria', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Servicios Profesionales', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Alimentos / Gastronomía', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Servicios Hospitalarios', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Servicios Turísticos', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Medio Ambiente', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Computación', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Inmobiliaria y bienes raíces ', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Gasolineria', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Refaccionaria', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Sector publico', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Efectivo', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Fundación', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
            ['nombre'=>'Eventos', 'descripcion'=>'','activo'=>1,'creado_por'=>1],
        ]);
    }
}
