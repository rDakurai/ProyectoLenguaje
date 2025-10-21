@extends('layouts.app')

@section('title', 'Editar horario - ' . $ruta->nombre)

@section('content')
<h1 class="h4 mb-3">Editar horario ({{ $ruta->nombre }})</h1>

<form method="POST" action="{{ route('admin.rutas.horarios.update', [$ruta, $horario]) }}" class="card shadow-sm">
  @csrf
  @method('PUT')

  <div class="card-body row g-3">
    {{-- Día --}}
    <div class="col-md-4">
      <label class="form-label">Día *</label>
      <select name="dia_semana" class="form-select @error('dia_semana') is-invalid @enderror">
        @foreach($dias as $d)
          <option value="{{ $d }}" {{ old('dia_semana', $horario->dia_semana) === $d ? 'selected' : '' }}>
            {{ $d }}
          </option>
        @endforeach
      </select>
      @error('dia_semana') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Hora salida --}}
    <div class="col-md-4">
      <label class="form-label">Hora salida *</label>
      <input type="time"
             name="hora_salida"
             class="form-control @error('hora_salida') is-invalid @enderror"
             value="{{ old('hora_salida', \Carbon\Carbon::parse($horario->hora_salida)->format('H:i')) }}">
      @error('hora_salida') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Sentido --}}
    <div class="col-md-4">
      <label class="form-label">Sentido *</label>
      <select name="sentido" class="form-select @error('sentido') is-invalid @enderror">
        <option value="Ida"    {{ old('sentido', $horario->sentido) === 'Ida' ? 'selected' : '' }}>Ida</option>
        <option value="Vuelta" {{ old('sentido', $horario->sentido) === 'Vuelta' ? 'selected' : '' }}>Vuelta</option>
      </select>
      @error('sentido') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="card-footer d-flex gap-2">
    <button class="btn btn-warning" type="submit">
      Guardar cambios
    </button>
    <a href="{{ route('rutas.show', $ruta) }}" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
@endsection

