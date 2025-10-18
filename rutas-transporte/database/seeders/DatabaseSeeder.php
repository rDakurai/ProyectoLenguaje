<?php

namespace Database\Seeders;

use App\Models\Horario;
use App\Models\Parada;
use App\Models\Ruta;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ruta = Ruta::create([
            'nombre' => 'Ruta Centro',
            'codigo' => 'R-001',
            'estado' => 'Activa',
            'color_ruta' => '#0d6efd',
        ]);

        $p1 = Parada::create(['nombre'=>'Terminal Norte', 'direccion'=>'Av. Principal 123']);
        $p2 = Parada::create(['nombre'=>'Plaza Central', 'direccion'=>'Calle 5ta esquina']);
        $p3 = Parada::create(['nombre'=>'Universidad', 'direccion'=>'Campus Principal']);

        $ruta->paradas()->attach($p1->id, ['orden'=>1, 'sentido'=>'Ida']);
        $ruta->paradas()->attach($p2->id, ['orden'=>2, 'sentido'=>'Ida']);
        $ruta->paradas()->attach($p3->id, ['orden'=>3, 'sentido'=>'Ida']);

        foreach (['Lunes','Martes','Miercoles','Jueves','Viernes'] as $d) {
            Horario::create(['ruta_id'=>$ruta->id, 'dia_semana'=>$d, 'hora_salida'=>'07:00:00', 'sentido'=>'Ida']);
            Horario::create(['ruta_id'=>$ruta->id, 'dia_semana'=>$d, 'hora_salida'=>'18:00:00', 'sentido'=>'Vuelta']);
        }
    }
}