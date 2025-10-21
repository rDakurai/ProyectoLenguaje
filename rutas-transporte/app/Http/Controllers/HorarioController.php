<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // ----------- MÉTODOS PARA RUTA -----------

    /** Form para crear un Horario para una Ruta concreta. */
    public function createForRuta(Ruta $ruta)
    {
        $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
        return view('admin.horarios.create', compact('ruta','dias'));
    }

    /** Guarda el horario y lo asocia a la ruta. */
    public function storeForRuta(Request $request, Ruta $ruta)
    {
        $data = $request->validate([
            'dia_semana'  => ['required','in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'],
            'hora_salida' => ['required','date_format:H:i'],
            'sentido'     => ['required','in:Ida,Vuelta'],
        ]);

        Horario::create([
            'ruta_id'     => $ruta->id,
            'dia_semana'  => $data['dia_semana'],
            'hora_salida' => $data['hora_salida'],
            'sentido'     => $data['sentido'],
        ]);

        return redirect()->route('rutas.show', $ruta)->with('ok', 'Horario añadido correctamente.');
    }

    /** Form de edición de un Horario de una Ruta. */
    public function editForRuta(Ruta $ruta, Horario $horario)
    {
        abort_unless($horario->ruta_id === $ruta->id, 404);
        $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
        return view('admin.horarios.edit', compact('ruta','horario','dias'));
    }

    /** Actualiza un Horario de una Ruta. */
    public function updateForRuta(Request $request, Ruta $ruta, Horario $horario)
    {
        abort_unless($horario->ruta_id === $ruta->id, 404);

        $data = $request->validate([
            'dia_semana'  => ['required','in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'],
            'hora_salida' => ['required','date_format:H:i'],
            'sentido'     => ['required','in:Ida,Vuelta'],
        ]);

        $horario->update($data);

        return redirect()->route('rutas.show', $ruta)->with('ok', 'Horario actualizado correctamente.');
    }

    /** Elimina un Horario de una Ruta. */
    public function destroyForRuta(Ruta $ruta, Horario $horario)
    {
        abort_unless($horario->ruta_id === $ruta->id, 404);

        $horario->delete();

        return redirect()->route('rutas.show', $ruta)->with('ok', 'Horario eliminado correctamente.');
    }

    // ----------- RESTO (scaffold opcional) -----------
    public function index()   { /* no usado aquí */ }
    public function create()  { /* no usado aquí */ }
    public function store(Request $request) { /* no usado aquí */ }
    public function show(Horario $horario)  { /* no usado aquí */ }
    public function edit(Horario $horario)  { /* no usado aquí */ }
    public function update(Request $request, Horario $horario) { /* no usado aquí */ }
    public function destroy(Horario $horario) { /* no usado aquí */ }
}

