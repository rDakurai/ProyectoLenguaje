@extends('layouts.app')
@section('title','Editar parada - '.$ruta->nombre)

@section('content')
<h1 class="h4 mb-3">Editar parada ({{ $ruta->nombre }})</h1>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.rutas.paradas.update', [$ruta, $parada]) }}" class="card p-3 shadow-sm">
  @csrf
  @method('PUT')

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre *</label>
      <input name="nombre" class="form-control" value="{{ old('nombre', $parada->nombre) }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Dirección</label>
      <input name="direccion" class="form-control" value="{{ old('direccion', $parada->direccion) }}">
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-warning" type="submit">Guardar cambios</button>
    <a href="{{ route('rutas.show',$ruta) }}" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
@endsection
