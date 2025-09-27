{{-- @extends('layouts.app') --}}
@extends('layouts.sidebar') 

@section('title','Usuarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Usuarios</h1>
  <a href="{{ route('ikiambio-users.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
          <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->full_name }}</td>
            <td>{{ $u->username }}</td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('ikiambio-users.show',$u) }}"><i class="fa fa-eye"></i></a>
              <a class="btn btn-sm btn-outline-warning" href="{{ route('ikiambio-users.edit',$u) }}"><i class="fa fa-edit"></i></a>
              <form class="d-inline" action="{{ route('ikiambio-users.destroy',$u) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Sin registros</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3">
  {{ $users->links() }}
</div>
@endsection


{{-- @extends('layouts.app')
@section('title','Usuarios')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Usuarios</h1>

<div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nombre</th>
        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Usuario</th>
        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Acciones</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 bg-white">
      @forelse($users as $u)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3 text-sm text-gray-700">{{ $u->id }}</td>
          <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $u->full_name }}</td>
          <td class="px-4 py-3 text-sm text-gray-700">{{ $u->username }}</td>
          <td class="px-4 py-3 text-sm text-right">
            <a class="text-indigo-600 hover:text-indigo-800 mr-3" href="{{ route('ikiambio-users.show',$u) }}"><i class="fa fa-eye"></i></a>
            <a class="text-amber-600 hover:text-amber-800 mr-3" href="{{ route('ikiambio-users.edit',$u) }}"><i class="fa fa-edit"></i></a>
            <form class="inline" action="{{ route('ikiambio-users.destroy',$u) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:text-red-800"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Sin registros</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6">
  {{ $users->links() }}
</div>
@endsection
 --}}