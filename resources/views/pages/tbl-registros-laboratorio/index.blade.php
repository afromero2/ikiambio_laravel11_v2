@extends('layouts.sidebar')
@section('page_title','Registros de laboratorio')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h5 m-0">Registros de laboratorio</h1>
  <a href="{{ route('tbl-registros-laboratorio.create') }}" class="btn btn-primary btn-sm">Nuevo</a>
</div>

<div class="card">
  <div class="card-body p-0">
    <table class="table table-sm mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>Extracción</th>
          <th>Vol ADN PCR</th>
          <th>Ampl. Succ Det</th>
          <th>Staff</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
      @forelse($items as $row)
        <tr>
          <td>{{ $row->idRegistrosLaboratorio }}</td>
          <td>{{ $row->idExtracciones }}</td>
          <td>{{ $row->vol_ADN_PCR ?? '—' }}</td>
          <td>{{ isset($row->amplificationSuccessDetails) ? ($row->amplificationSuccessDetails ? 'Sí' : 'No') : '—' }}</td>
          <td>{{ $row->sequencingStaff ?? '—' }}</td>
          <td class="text-end text-nowrap">
            <a href="{{ route('tbl-registros-laboratorio.show', $row) }}" class="btn btn-outline-secondary btn-sm" title="Ver">
              <i class="fa-solid fa-eye"></i>
            </a>
            <a href="{{ route('tbl-registros-laboratorio.edit', $row) }}" class="btn btn-outline-warning btn-sm" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <form action="{{ route('tbl-registros-laboratorio.destroy', $row) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('¿Eliminar este registro?')">
              @csrf @method('DELETE')
              <button class="btn btn-outline-danger btn-sm" type="submit" title="Eliminar">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Sin registros</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  {{ $items->links() }}
</div>
@endsection
