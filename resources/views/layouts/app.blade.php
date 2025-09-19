
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name','IKIAMBIO'))</title>
  @vite('resources/js/app.js')
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
  <div class="container">
    <a class="navbar-brand" href="{{ route('users.index') }}">IKIAMBIO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav01">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav01" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('users.create') }}">Nuevo</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif
  @yield('content')
</main>
</body>
</html>