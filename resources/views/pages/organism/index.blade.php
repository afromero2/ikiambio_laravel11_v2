@extends('layouts.sidebar')

@section('title','Organisms — Lista')
@section('page_title','Organisms')

@section('content')
  @php use Illuminate\Support\Str; @endphp

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Organisms</h2>
    <a href="{{ route('organism.create') }}" class="btn btn-primary">Nuevo</a>
  </div>

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
            <th>Organism ID</th>
            <th>Associated Occurrences</th>
            <th>Associated Organisms</th>
            <th>Previous Identifications</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $row)
            <tr>
              <td class="fw-semibold">{{ $row->organismID }}</td>
              <td>{{ Str::limit($row->associatedOccurrences, 60) }}</td>
              <td>{{ Str::limit($row->associatedOrganisms, 60) }}</td>
              <td>{{ Str::limit($row->previousIdentifications, 60) }}</td>
              <td class="text-end">
                <a href="{{ route('organism.show',$row->organismID) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                <a href="{{ route('organism.edit',$row->organismID) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                <form action="{{ route('organism.destroy',$row->organismID) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este registro?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted">Sin registros</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{{ $items->links() }}}
  </div>
@endsection
