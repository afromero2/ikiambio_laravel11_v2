@extends('layouts.sidebar')

@section('title','Record Level — Listado')
@section('page_title','Record Level')

@section('content')
<div class="container btnForms">
    <h2>Detalle Usuario</h2>

    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Username:</strong> {{ $user->username }}</p>
    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Apellido:</strong> {{ $user->lastname }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Administrador:</strong> {{ $user->is_admin ? 'Sí' : 'No' }}</p>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver</a>
     <a class="btn btn-secondary" href="{{ route('users.edit',$user) }}">Editar</a>

</div>
@endsection
