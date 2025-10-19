<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Rutas & Horarios')</title>

  {{-- Bootstrap 5 (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background: #f8fafc; }
    .app-nav { backdrop-filter: blur(6px); }
    .card-hover { transition: transform .15s ease, box-shadow .15s ease; }
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 6px 22px rgba(0,0,0,.08); }
    .pill-light { background:#f1f5f9; border-radius:999px; padding:.35rem .65rem; font-size:.85rem; }
    .sticky-tools { position: sticky; top: .5rem; z-index: 5; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom app-nav">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="{{ route('rutas.index') }}">
      <i class="bi bi-bus-front me-2"></i>Rutas Transporte
    </a>
  </div>
</nav>

<main class="container py-4">
  @yield('content')
</main>

<footer class="border-top bg-white">
  <div class="container py-3 text-secondary small d-flex justify-content-between">
    <span>© {{ date('Y') }} Rutas Transporte</span>
    <span>UEES · Demo</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
