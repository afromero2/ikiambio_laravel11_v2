@extends('layouts.sidebar')

@section('title','Record Level — Listado')
@section('page_title','Record Level')

@section('content')

<div class="container btnForms">
    <h2>Listado de Usuarios</h2>

    <a href="{{ route('users.create') }}" class="btn btn-secondary">
        Nuevo Usuario
    </a>

    <table style="width:100%; margin-top:20px; border-collapse: collapse;">
        <thead>
            <tr style="background:#f0f0f0;">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Username</th>
                <th style="text-align:center">Nombre</th>
                <th style="text-align:center">Apellido</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Admin</th>
                <th style="text-align:center">Funcionalidades</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom:1px solid #ccc;">
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Sí' : 'No' }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('users.show',$user) }}">Ver</a>
                    <a class="btn btn-sm btn-outline-warning" href="{{ route('users.edit',$user) }}">Editar</a>
                    <form class="d-inline" action="{{ route('users.destroy',$user) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-warning">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection