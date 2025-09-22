@extends('layouts.sidebar')

@section('title','Record Level — Listado')
@section('page_title','Record Level')

@section('content')

<div class="container">
    <h2>Listado de Usuarios</h2>

    <a href="{{ route('users.create') }}">
        <button>Nuevo Usuario</button>
    </a>

    <table style="width:100%; margin-top:20px; border-collapse: collapse;">
        <thead>
            <tr style="background:#f0f0f0;">
                <th>ID</th>
                <th>Username</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Funcionalidades</th>
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
                    <form class="d-inline2" action="{{ route('users.destroy',$user) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
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