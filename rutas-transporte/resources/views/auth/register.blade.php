@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h4 class="mb-3">Crear cuenta</h4>

        <form method="POST" action="{{ route('register.post') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input class="form-control" type="password" name="password" required>
            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input class="form-control" type="password" name="password_confirmation" required>
          </div>

          <button class="btn btn-primary w-100" type="submit">Registrarse</button>

          <div class="text-center mt-3">
            <a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

