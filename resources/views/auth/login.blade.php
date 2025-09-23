<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Login — IKIAM')</title>
  @vite(['resources/css/utility.css'])
</head>
<body>
<div class="container">
    <h1>Login</h1>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form class="login" method="POST" action="/login">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Ingresar</button>
    </form>
</div>
</body>
</html>
