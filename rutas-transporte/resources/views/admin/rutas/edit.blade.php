@extends('layouts.app')
@section('title','Editar ruta')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h4 class="mb-3">Editar Ruta</h4>
        <form method="POST" action="{{ route('admin.rutas.update', $ruta) }}">
          @method('PUT')
          @include('admin.rutas._form', ['btnText' => 'Actualizar'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

