@extends('layouts.sidebar')

@section('title','Record Level — Listado')
@section('page_title','Record Level')

@section('content')

<div class="container">
    <h2>Alta de Usuario</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups! Hubo algunos problemas con tu entrada:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="btnForms" method="POST" action="{{ route('users.store') }}">
        @csrf
        <label>Username</label>
        <input type="text" name="username" value="{{ old('username') }}" required>

        <label>Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Apellido</label>
        <input type="text" name="lastname" value="{{ old('lastname') }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Contraseña</label>
        <input type="password" name="password" value="{{ old('password') }}" required>

        <div class="form-check">
            <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input"
                value="1" {{ old('is_admin') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_admin">&nbsp;&nbsp;Es administrador</label>
        </div><br/>

        <button type="submit">Crear Usuario</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
@endsection
