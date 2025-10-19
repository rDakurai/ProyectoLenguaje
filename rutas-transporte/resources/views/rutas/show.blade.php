@extends('layouts.app')

@section('title', $ruta->nombre . ' - Detalle')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h1 class="h3 mb-1">{{ $ruta->nombre }}</h1>
    @if($ruta->descripcion)
      <p class="text-secondary mb-0">{{ $ruta->descripcion }}</p>
    @endif
  </div>
  <a class="btn btn-link" href="{{ route('rutas.index') }}"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="row g-4">
  {{-- Paradas --}}
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="tabParadas" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-ida" data-bs-toggle="tab" data-bs-target="#panel-ida" type="button" role="tab">
              Paradas (Ida)
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-vuelta" data-bs-toggle="tab" data-bs-target="#panel-vuelta" type="button" role="tab">
              Paradas (Vuelta)
            </button>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content">
          {{-- Ida --}}
          <div class="tab-pane fade show active" id="panel-ida" role="tabpanel" aria-labelledby="tab-ida">
            @if($ruta->paradasIda->count())
              <ol class="list-group list-group-numbered">
                @foreach($ruta->paradasIda as $p)
                  <li class="list-group-item">{{ $p->nombre }}</li>
                @endforeach
              </ol>
            @else
              <div class="text-secondary">Sin paradas para Ida.</div>
            @endif
          </div>
          {{-- Vuelta --}}
          <div class="tab-pane fade" id="panel-vuelta" role="tabpanel" aria-labelledby="tab-vuelta">
            @if($ruta->paradasVuelta->count())
              <ol class="list-group list-group-numbered">
                @foreach($ruta->paradasVuelta as $p)
                  <li class="list-group-item">{{ $p->nombre }}</li>
                @endforeach
              </ol>
            @else
              <div class="text-secondary">Sin paradas para Vuelta.</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Horarios --}}
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-header d-flex align-items-center gap-2">
        <span class="fw-semibold">Horarios</span>
        <div class="ms-auto d-flex align-items-center gap-2 sticky-tools">
          <select id="filtroDia" class="form-select form-select-sm" style="max-width: 200px;">
            <option value="">Todos los días</option>
            @foreach($dias as $d)
              <option value="{{ $d }}">{{ $d }}</option>
            @endforeach
          </select>
          <select id="filtroSentido" class="form-select form-select-sm" style="max-width: 160px;">
            <option value="">Ambos sentidos</option>
            <option value="Ida">Ida</option>
            <option value="Vuelta">Vuelta</option>
          </select>
        </div>
      </div>

      <div class="card-body">
        @php $horarios = $ruta->horarios; @endphp

        @if($horarios->count())
          <div class="table-responsive">
            <table class="table table-sm table-striped align-middle" id="tablaHorarios">
              <thead class="table-light">
                <tr>
                  <th>Día</th>
                  <th>Sentido</th>
                  <th>Hora salida</th>
                </tr>
              </thead>
              <tbody>
                @foreach($horarios as $h)
                  <tr data-dia="{{ $h->dia_semana }}" data-sentido="{{ $h->sentido }}">
                    <td>{{ $h->dia_semana }}</td>
                    <td>
                      <span class="pill-light">{{ $h->sentido }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($h->hora_salida)->format('H:i') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-secondary">Sin horarios disponibles.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
  const filtroDia = document.getElementById('filtroDia');
  const filtroSentido = document.getElementById('filtroSentido');
  const filas = () => Array.from(document.querySelectorAll('#tablaHorarios tbody tr'));

  function aplicarFiltros() {
    const dia = filtroDia.value.trim();
    const sentido = filtroSentido.value.trim();

    filas().forEach(tr => {
      const okDia = !dia || tr.dataset.dia === dia;
      const okSentido = !sentido || tr.dataset.sentido === sentido;
      tr.style.display = (okDia && okSentido) ? '' : 'none';
    });
  }

  filtroDia?.addEventListener('change', aplicarFiltros);
  filtroSentido?.addEventListener('change', aplicarFiltros);
})();
</script>
@endpush
