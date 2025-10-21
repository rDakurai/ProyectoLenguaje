@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h4 class="mb-3">Iniciar sesión</h4>

        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input class="form-control" type="password" name="password" required>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
          </div>

          <button class="btn btn-primary w-100" type="submit">Entrar</button>

          <div class="text-center mt-3">
            <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

