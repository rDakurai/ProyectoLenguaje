@extends('layouts.app')
@section('title','Nuevo horario - '.$ruta->nombre)

@section('content')
<h1 class="h4 mb-3">Nuevo horario para: {{ $ruta->nombre }}</h1>

<form method="POST" action="{{ route('admin.rutas.horarios.store', $ruta) }}" class="card p-3 shadow-sm">
  @csrf
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Día *</label>
      <select name="dia_semana" class="form-select" required>
        @foreach($dias as $d)
          <option value="{{ $d }}">{{ $d }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Hora salida (HH:MM) *</label>
      <input name="hora_salida" type="time" class="form-control" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Sentido *</label>
      <select name="sentido" class="form-select" required>
        <option value="Ida">Ida</option>
        <option value="Vuelta">Vuelta</option>
      </select>
    </div>
  </div>
  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-success" type="submit">Guardar</button>
    <a href="{{ route('rutas.show',$ruta) }}" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
@endsection

