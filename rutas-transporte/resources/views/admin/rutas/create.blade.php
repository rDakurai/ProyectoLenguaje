@extends('layouts.app')
@section('title','Crear ruta')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h4 class="mb-3">Nueva Ruta</h4>
        <form method="POST" action="{{ route('admin.rutas.store') }}">
          @include('admin.rutas._form', ['btnText' => 'Crear'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

