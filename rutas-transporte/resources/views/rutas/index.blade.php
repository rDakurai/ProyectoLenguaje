@extends('layouts.app')

@section('title', 'Listado de rutas')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h3 mb-0">Rutas disponibles</h1>
  <form method="GET" action="{{ route('rutas.index') }}" class="d-flex gap-2" role="search">
    <input name="q" value="{{ $q }}" type="search" class="form-control" placeholder="Buscar ruta...">
    <button class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
  </form>
</div>

@if($rutas->count())
  <div class="row g-3">
    @foreach($rutas as $ruta)
      <div class="col-sm-6 col-lg-4">
        <div class="card h-100 shadow-sm card-hover">
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h5 class="card-title mb-0">{{ $ruta->nombre }}</h5>
              @isset($ruta->paradas_count)
                <span class="pill-light" title="Paradas totales">
                  <i class="bi bi-geo-alt"></i> {{ $ruta->paradas_count }}
                </span>
              @endisset
            </div>
            <p class="text-secondary small flex-grow-1 mb-3">
              {{ $ruta->descripcion ?: 'Sin descripción' }}
            </p>
            <div class="d-flex justify-content-between">
              @isset($ruta->horarios_count)
                <span class="text-secondary small"><i class="bi bi-clock-history me-1"></i>{{ $ruta->horarios_count }} horarios</span>
              @endisset
              <a class="btn btn-outline-primary" href="{{ route('rutas.show', $ruta) }}">
                Ver paradas y horarios
              </a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4">
    {{ $rutas->links() }}
  </div>
@else
  <div class="text-center text-secondary py-5">
    <i class="bi bi-signpost-2 fs-1 d-block mb-2"></i>
    No encontramos rutas para <strong>{{ $q }}</strong>.
    <div class="mt-2">
      <a class="btn btn-sm btn-secondary" href="{{ route('rutas.index') }}"><i class="bi bi-x-circle"></i> Limpiar</a>
    </div>
  </div>
@endif
@endsection
