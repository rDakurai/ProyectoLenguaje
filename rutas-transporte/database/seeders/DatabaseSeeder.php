<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Ruta;
use App\Models\Parada;
use App\Models\Horario;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpieza para desarrollo (evita duplicados si corres varias veces)
        Schema::disableForeignKeyConstraints();
        DB::table('ruta_parada')->truncate();
        DB::table('horarios')->truncate();
        DB::table('paradas')->truncate();
        DB::table('rutas')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1) Crear una ruta de ejemplo
        $ruta = Ruta::create([
            'nombre' => 'Ruta 1',
            'descripcion' => 'Recorrido principal centro - norte',
        ]);

        // 2) Crear paradas
        $p1 = Parada::create(['nombre' => 'Parada A', 'direccion' => 'Av. 1 y Calle A']);
        $p2 = Parada::create(['nombre' => 'Parada B', 'direccion' => 'Av. 2 y Calle B']);
        $p3 = Parada::create(['nombre' => 'Parada C', 'direccion' => 'Av. 3 y Calle C']);

        // 3) Asociar paradas a la ruta con orden y sentido
        // Ida: A (1) -> B (2) -> C (3)
        $ruta->paradas()->attach($p1->id, ['orden' => 1, 'sentido' => 'Ida']);
        $ruta->paradas()->attach($p2->id, ['orden' => 2, 'sentido' => 'Ida']);
        $ruta->paradas()->attach($p3->id, ['orden' => 3, 'sentido' => 'Ida']);

        // Vuelta: C (1) -> B (2) -> A (3)
        $ruta->paradas()->attach($p3->id, ['orden' => 1, 'sentido' => 'Vuelta']);
        $ruta->paradas()->attach($p2->id, ['orden' => 2, 'sentido' => 'Vuelta']);
        $ruta->paradas()->attach($p1->id, ['orden' => 3, 'sentido' => 'Vuelta']);

        // 4) Horarios por día y sentido
        $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

        foreach ($dias as $dia) {
            // Tres salidas de ejemplo por día (Ida)
            Horario::create([
                'ruta_id' => $ruta->id,
                'dia_semana' => $dia,
                'hora_salida' => '07:00',
                'sentido' => 'Ida',
            ]);
            Horario::create([
                'ruta_id' => $ruta->id,
                'dia_semana' => $dia,
                'hora_salida' => '12:00',
                'sentido' => 'Ida',
            ]);
            Horario::create([
                'ruta_id' => $ruta->id,
                'dia_semana' => $dia,
                'hora_salida' => '18:00',
                'sentido' => 'Ida',
            ]);

            // Dos salidas de ejemplo por día (Vuelta)
            Horario::create([
                'ruta_id' => $ruta->id,
                'dia_semana' => $dia,
                'hora_salida' => '09:00',
                'sentido' => 'Vuelta',
            ]);
            Horario::create([
                'ruta_id' => $ruta->id,
                'dia_semana' => $dia,
                'hora_salida' => '20:00',
                'sentido' => 'Vuelta',
            ]);
        }
    }
}
