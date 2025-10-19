@extends('layouts.app')

@section('title', 'Listado de rutas')

@section('content')
<div class="row mb-3">
  <div class="col-lg-8">
    <h1 class="h3">Rutas disponibles</h1>
  </div>
  <div class="col-lg-4">
    <form method="GET" action="{{ route('rutas.index') }}">
      <div class="input-group">
        <input name="q" value="{{ $q }}" type="search" class="form-control" placeholder="Buscar ruta...">
        <button class="btn btn-primary" type="submit">Buscar</button>
      </div>
    </form>
  </div>
</div>

@if($rutas->count())
  <div class="row g-3">
    @foreach($rutas as $ruta)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-2">{{ $ruta->nombre }}</h5>
            @if($ruta->descripcion)
              <p class="text-secondary small flex-grow-1">{{ $ruta->descripcion }}</p>
            @else
              <p class="text-secondary small flex-grow-1">Sin descripción</p>
            @endif
            <a class="btn btn-outline-primary mt-2" href="{{ route('rutas.show', $ruta) }}">
              Ver paradas y horarios
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4">
    {{ $rutas->links() }}
  </div>
@else
  <div class="alert alert-warning">No hay rutas para mostrar.</div>
@endif
@endsection
