<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Parada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParadaController extends Controller
{
    // ----------- MÉTODOS PARA RUTA -----------

    /** Form para crear y asociar una Parada a una Ruta concreta. */
    public function createForRuta(Ruta $ruta)
    {
        return view('admin.paradas.create', compact('ruta'));
    }

    /** Guarda la parada (creándola si no existe) y la asocia a la ruta con orden/sentido. */
    public function storeForRuta(Request $request, Ruta $ruta)
    {
        $data = $request->validate([
            'nombre'    => ['required','string','max:255'],
            'direccion' => ['nullable','string','max:255'],
            'sentido'   => ['required','in:Ida,Vuelta'],
            'orden'     => ['required','integer','min:1'],
        ]);

        $parada = Parada::firstOrCreate(
            ['nombre' => $data['nombre']],
            ['direccion' => $data['direccion'] ?? null]
        );

        $yaExiste = $ruta->paradas()
            ->where('paradas.id', $parada->id)
            ->wherePivot('sentido', $data['sentido'])
            ->wherePivot('orden', $data['orden'])
            ->exists();

        if (!$yaExiste) {
            $ruta->paradas()->attach($parada->id, [
                'orden'   => $data['orden'],
                'sentido' => $data['sentido'],
            ]);
        }

        return redirect()->route('rutas.show', $ruta)->with('ok', 'Parada añadida correctamente.');
    }

    /** Form de edición de una Parada dentro de una Ruta (datos de la parada). */
    public function editForRuta(Ruta $ruta, Parada $parada)
    {
        $existe = $ruta->paradas()->where('paradas.id', $parada->id)->exists();
        abort_unless($existe, 404);

        return view('admin.paradas.edit', compact('ruta','parada'));
    }

    /** Actualiza la Parada (nombre/dirección) dentro de una Ruta. */
    public function updateForRuta(Request $request, Ruta $ruta, Parada $parada)
    {
        $existe = $ruta->paradas()->where('paradas.id', $parada->id)->exists();
        abort_unless($existe, 404);

        $data = $request->validate([
            'nombre'    => ['required','string','max:255'],
            'direccion' => ['nullable','string','max:255'],
        ]);

        $parada->update($data);

        return redirect()->route('rutas.show', $ruta)->with('ok', 'Parada actualizada correctamente.');
    }

    /** Elimina la relación Ruta-Parada para un sentido (Ida/Vuelta). */
    public function destroyForRuta(Request $request, Ruta $ruta, Parada $parada)
    {
        $data = $request->validate([
            'sentido' => ['required','in:Ida,Vuelta'],
        ]);

        // Asegurar que la parada está vinculada a la ruta
        $existe = $ruta->paradas()->where('paradas.id', $parada->id)->exists();
        abort_unless($existe, 404);

        // Borramos SOLO el vínculo del pivote para el sentido indicado
        DB::table('ruta_parada')
            ->where('ruta_id', $ruta->id)
            ->where('parada_id', $parada->id)
            ->where('sentido', $data['sentido'])
            ->delete();

        return redirect()->route('rutas.show', $ruta)->with('ok', 'Parada eliminada del recorrido.');
    }

    // ----------- RESTO (scaffold opcional) -----------
    public function index()   { /* no usado aquí */ }
    public function create()  { /* no usado aquí */ }
    public function store(Request $request) { /* no usado aquí */ }
    public function show(Parada $parada)    { /* no usado aquí */ }
    public function edit(Parada $parada)    { /* no usado aquí */ }
    public function update(Request $request, Parada $parada) { /* no usado aquí */ }
    public function destroy(Parada $parada) { /* no usado aquí */ }
}

