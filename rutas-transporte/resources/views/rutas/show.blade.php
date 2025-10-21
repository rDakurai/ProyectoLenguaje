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

  <div class="d-flex align-items-center gap-2">
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('rutas.index') }}">
      <i class="bi bi-arrow-left"></i> Volver
    </a>

    @auth
      @if(auth()->user()->is_admin ?? false)
        <div class="btn-group">
          <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-plus-lg"></i> Añadir
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="{{ route('admin.rutas.paradas.create', $ruta) }}">
                <i class="bi bi-geo-alt me-2"></i> Nueva parada
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('admin.rutas.horarios.create', $ruta) }}">
                <i class="bi bi-clock me-2"></i> Nuevo horario
              </a>
            </li>
          </ul>
        </div>

        {{-- (Se eliminó el botón Eliminar de la cabecera) --}}
      @endif
    @endauth
  </div>
</div>

@php
  $isAdmin = auth()->check() && (auth()->user()->is_admin ?? false);
@endphp

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
              <ul class="list-group">
                @foreach($ruta->paradasIda as $p)
                  <li class="list-group-item d-flex align-items-center">
                    <span class="text-secondary small me-3" style="width:2rem; text-align:right;">{{ $loop->iteration }}.</span>
                    <span class="flex-grow-1 text-center">{{ $p->nombre }}</span>

                    @if($isAdmin)
                      <div class="d-inline-flex gap-1 ms-3">
                        <a href="{{ route('admin.rutas.paradas.edit', [$ruta, $p]) }}"
                           class="btn btn-sm btn-outline-warning" title="Editar parada">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger js-open-delete"
                                title="Eliminar parada (Ida)"
                                data-action="{{ route('admin.rutas.paradas.destroy', [$ruta, $p]) }}"
                                data-sentido="Ida">
                          <i class="bi bi-trash3"></i>
                        </button>
                      </div>
                    @endif
                  </li>
                @endforeach
              </ul>
            @else
              <div class="text-secondary">Sin paradas para Ida.</div>
            @endif
          </div>

          {{-- Vuelta --}}
          <div class="tab-pane fade" id="panel-vuelta" role="tabpanel" aria-labelledby="tab-vuelta">
            @if($ruta->paradasVuelta->count())
              <ul class="list-group">
                @foreach($ruta->paradasVuelta as $p)
                  <li class="list-group-item d-flex align-items-center">
                    <span class="text-secondary small me-3" style="width:2rem; text-align:right;">{{ $loop->iteration }}.</span>
                    <span class="flex-grow-1 text-center">{{ $p->nombre }}</span>

                    @if($isAdmin)
                      <div class="d-inline-flex gap-1 ms-3">
                        <a href="{{ route('admin.rutas.paradas.edit', [$ruta, $p]) }}"
                           class="btn btn-sm btn-outline-warning" title="Editar parada">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger js-open-delete"
                                title="Eliminar parada (Vuelta)"
                                data-action="{{ route('admin.rutas.paradas.destroy', [$ruta, $p]) }}"
                                data-sentido="Vuelta">
                          <i class="bi bi-trash3"></i>
                        </button>
                      </div>
                    @endif
                  </li>
                @endforeach
              </ul>
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
                  @if($isAdmin)
                    <th class="text-end">Acciones</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($horarios as $h)
                  <tr data-dia="{{ $h->dia_semana }}" data-sentido="{{ $h->sentido }}">
                    <td>{{ $h->dia_semana }}</td>
                    <td><span class="pill-light">{{ $h->sentido }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($h->hora_salida)->format('H:i') }}</td>
                    @if($isAdmin)
                      <td class="text-end">
                        <div class="d-inline-flex gap-1">
                          <a href="{{ route('admin.rutas.horarios.edit', [$ruta, $h]) }}"
                             class="btn btn-sm btn-outline-warning" title="Editar horario">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <button type="button"
                                  class="btn btn-sm btn-outline-danger js-open-delete"
                                  title="Eliminar horario"
                                  data-action="{{ route('admin.rutas.horarios.destroy', [$ruta, $h]) }}">
                            <i class="bi bi-trash3"></i>
                          </button>
                        </div>
                      </td>
                    @endif
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

{{-- Modal de confirmación (reutilizable para paradas y horarios) --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que deseas eliminar este elemento? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          {{-- Para paradas: se setea cuando aplique; para horarios queda vacío --}}
          <input type="hidden" name="sentido" id="deleteSentido" value="">
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
  // Filtros de horarios
  const filtroDia = document.getElementById('filtroDia');
  const filtroSentido = document.getElementById('filtroSentido');
  const filas = () => Array.from(document.querySelectorAll('#tablaHorarios tbody tr'));

  function aplicarFiltros() {
    const dia = (filtroDia?.value || '').trim();
    const sentido = (filtroSentido?.value || '').trim();

    filas().forEach(tr => {
      const okDia = !dia || tr.dataset.dia === dia;
      const okSentido = !sentido || tr.dataset.sentido === sentido;
      tr.style.display = (okDia && okSentido) ? '' : 'none';
    });
  }
  filtroDia?.addEventListener('change', aplicarFiltros);
  filtroSentido?.addEventListener('change', aplicarFiltros);

  // Modal de eliminación
  const modalEl = document.getElementById('confirmDeleteModal');
  const deleteForm = document.getElementById('deleteForm');
  const deleteSentido = document.getElementById('deleteSentido');
  let bsModal = null;
  if (modalEl) bsModal = new bootstrap.Modal(modalEl);

  document.querySelectorAll('.js-open-delete').forEach(btn => {
    btn.addEventListener('click', () => {
      const action = btn.dataset.action || '';
      const sentido = btn.dataset.sentido || '';
      deleteForm.action = action;
      deleteSentido.value = sentido; // vacío para horarios
      bsModal?.show();
    });
  });
})();
</script>
@endpush










