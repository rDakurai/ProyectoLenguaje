@extends('layouts.app')

@section('title', 'Listado de rutas')

@section('content')
{{-- Encabezado en 3 columnas: Título | Selector (arriba) + Botones (abajo, centrados) | Buscador --}}
<div class="row align-items-center g-2 mb-3">
  {{-- IZQUIERDA: título --}}
  <div class="col-12 col-lg-3">
    <h1 class="h3 mb-0">Rutas disponibles</h1>
  </div>

  {{-- CENTRO: selector (arriba) + botones (abajo) --}}
  <div class="col-12 col-lg-6">
    @auth
      @if(auth()->user()->is_admin ?? false)
        {{-- Selector (MUCHO más pequeño) --}}
        <div class="d-flex justify-content-center mb-2">
          @php $listaParaSelector = (isset($todasRutas) ? $todasRutas : $rutas); @endphp
          <select id="adminRutaSelect" class="form-select form-select-sm w-auto" style="min-width:140px">
            <option value="">Seleccionar ruta…</option>
            @foreach($listaParaSelector as $r)
              <option value="{{ $r->id }}">{{ $r->nombre }}</option>
            @endforeach
          </select>
        </div>

        {{-- Botones (misma línea, tamaño PEQUEÑO, centrados) --}}
        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
          <a href="{{ route('admin.rutas.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Nueva ruta
          </a>

          <a id="adminBtnEdit" href="#" class="btn btn-warning btn-sm disabled">
            <i class="bi bi-pencil-square"></i> Editar
          </a>

          <form id="adminFormDelete" action="#" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <!-- Abrir modal en lugar de enviar directo -->
            <button id="adminBtnDelete" type="button" class="btn btn-outline-danger btn-sm" disabled
                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
              <i class="bi bi-trash3"></i> Eliminar
            </button>
          </form>
        </div>
      @endif
    @endauth
  </div>

  {{-- DERECHA: buscador --}}
  <div class="col-12 col-lg-3">
    <form method="GET" action="{{ route('rutas.index') }}" class="d-flex gap-2 justify-content-lg-end" role="search">
      <input name="q" value="{{ $q }}" type="search" class="form-control" placeholder="Buscar ruta..." style="min-width:220px">
      <button class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
    </form>
  </div>
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

<!-- Modal confirmar eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que deseas eliminar esta ruta? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Sí, eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
  const select = document.getElementById('adminRutaSelect');
  if (!select) return;

  const btnEdit = document.getElementById('adminBtnEdit');
  const formDel = document.getElementById('adminFormDelete');
  const btnDel  = document.getElementById('adminBtnDelete');

  const base = '{{ url('/admin/rutas') }}'; // /admin/rutas

  function actualizarAcciones() {
    const id = select.value;
    if (id) {
      btnEdit.href = `${base}/${id}/edit`;
      btnEdit.classList.remove('disabled');

      formDel.action = `${base}/${id}`;
      btnDel.removeAttribute('disabled');
    } else {
      btnEdit.href = '#';
      btnEdit.classList.add('disabled');

      formDel.action = '#';
      btnDel.setAttribute('disabled', 'disabled');
    }
  }

  select.addEventListener('change', actualizarAcciones);

  // Enviar el formulario al confirmar en el modal
  const confirmBtn = document.getElementById('confirmDeleteBtn');
  confirmBtn?.addEventListener('click', () => document.getElementById('adminFormDelete').submit());
})();
</script>
@endpush








