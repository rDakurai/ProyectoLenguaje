<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Rutas & Horarios')</title>

  {{-- Bootstrap 5 por CDN (sin npm) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom mb-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('rutas.index') }}">Rutas Transporte</a>
  </div>
</nav>

<main class="container pb-5">
  @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
