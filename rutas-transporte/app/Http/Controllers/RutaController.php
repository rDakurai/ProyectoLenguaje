<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    // LISTADO + BÚSQUEDA
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $rutas = Ruta::query()
            ->when($q, fn($qb) => $qb->where('nombre', 'like', "%{$q}%"))
            ->withCount(['paradas as paradas_count', 'horarios']) // contadores (asegúrate que existan esas relaciones)
            ->orderBy('nombre')
            ->paginate(9)
            ->withQueryString();

        $todasRutas = Ruta::orderBy('nombre')->get();
        return view('rutas.index', compact('rutas', 'q', 'todasRutas'));
    }

    // DETALLE
    public function show(Ruta $ruta)
    {
        // Orden fijo para los días
        $ordenDias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

        // Cargar relaciones ya ordenadas
        $ruta->load([
            'paradasIda',
            'paradasVuelta',
            'horarios' => fn($q) => $q
                ->orderByRaw("FIELD(dia_semana,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')")
                ->orderByRaw("FIELD(sentido,'Ida','Vuelta')")
                ->orderBy('hora_salida'),
        ]);

        // Días disponibles para el select, respetando el orden fijo
        $diasDisponibles = $ruta->horarios()->select('dia_semana')->distinct()->pluck('dia_semana')->all();
        $dias = array_values(array_intersect($ordenDias, $diasDisponibles));

        return view('rutas.show', compact('ruta', 'dias'));
    }

    // ---- CRUD SOLO ADMIN (rutas/web.php debe proteger con ['auth','admin']) ----

    // CREATE
    public function create()
    {
        return view('admin.rutas.create');
    }

    // STORE
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'descripcion' => ['nullable','string','max:1000'],
        ]);

        Ruta::create($data);

        return redirect()
            ->route('rutas.index')
            ->with('ok', 'Ruta creada correctamente.');
    }

    // EDIT
    public function edit(Ruta $ruta)
    {
        return view('admin.rutas.edit', compact('ruta'));
    }

    // UPDATE
    public function update(Request $request, Ruta $ruta)
    {
        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'descripcion' => ['nullable','string','max:1000'],
        ]);

        $ruta->update($data);

        return redirect()
            ->route('rutas.show', $ruta)
            ->with('ok', 'Ruta actualizada.');
    }

    // DESTROY
    public function destroy(Ruta $ruta)
    {
        $ruta->delete();

        return redirect()
            ->route('rutas.index')
            ->with('ok', 'Ruta eliminada.');
    }
}

