@extends('layouts.sidebar')

@section('title','Location — Lista')
@section('page_title','Locations')

@section('content')
  @if(auth()->user()->is_admin)
    <div class="d-flex justify-content-between align-items-center mb-3 btnForms">
      <h2 class="m-0">Locations</h2>
      <a href="{{ route('location.create') }}" class="btn btn-primary">Nuevo</a>
    </div>
  @endif
  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Locality</th>
            <th>Country</th>
            <th>State/Province</th>
            <th>Continent</th>
            <th>Verbatim SRS</th>
            <th>Georef. Status</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $row)
            <tr>
              <td>{{ $row->locationID }}</td>
              <td>{{ $row->locality }}</td>
              <td>{{ $row->country }}</td>
              <td>{{ $row->stateProvince }}</td>
              <td>{{ $row->continentRef?->continent_value }}</td>
              <td>{{ $row->verbatimSrsRef?->verbatimSRS_value }}</td>
              <td>{{ $row->georefStatusRef?->georef_status_value }}</td>
              <td class="text-end">
                <a href="{{ route('location.show',$row->locationID) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                <a href="{{ route('location.edit',$row->locationID) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                <form action="{{ route('location.destroy',$row->locationID) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este registro?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center text-muted">Sin registros</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{{ $items->links() }}}
  </div>
@endsection
