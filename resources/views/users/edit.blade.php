@extends('layouts.sidebar')

@section('title','Record Level — Listado')
@section('page_title','Record Level')

@section('content')
<div class="container btnForms">
    <h2>Editar Usuario</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <label>Username</label>
        <input type="text" name="username" value="{{ $user->username }}" required>

        <label>Nombre</label>
        <input type="text" name="name" value="{{ $user->name }}" required>

        <label>Apellido</label>
        <input type="text" name="lastname" value="{{ $user->lastname }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required>

        <label>Es Administrador</label>
        <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>

        <button type="submit">Actualizar Usuario</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
@endsection
