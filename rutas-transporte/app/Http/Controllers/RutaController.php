<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $rutas = Ruta::query()
            ->when($q, fn($qbuilder) => $qbuilder->where('nombre', 'like', "%{$q}%"))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('rutas.index', compact('rutas', 'q'));
    }

    public function show(Ruta $ruta)
    {
    // Orden fijo para los días
    $ordenDias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

    // Cargar relaciones con orden ya desde la BD
    $ruta->load([
        'paradasIda',
        'paradasVuelta',
        'horarios' => fn($q) => $q
            ->orderByRaw("FIELD(dia_semana,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')")
            ->orderByRaw("FIELD(sentido,'Ida','Vuelta')")
            ->orderBy('hora_salida'),
    ]);

    // Días disponibles para el select, pero en el orden definido
    $diasDisponibles = $ruta->horarios()->select('dia_semana')->distinct()->pluck('dia_semana')->all();
    $dias = array_values(array_intersect($ordenDias, $diasDisponibles));

    return view('rutas.show', compact('ruta', 'dias'));
    }

}
