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
            <th class="text-center">Eventos asociados</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @php $page = $items->currentPage() ?? old('page', request('page', 1)); @endphp
          @forelse($items as $row)
            <tr>
              <td>{{ $row->locationID }}</td>
              <td>{{ $row->locality }}</td>
              <td>{{ $row->country }}</td>
              <td>{{ $row->stateProvince }}</td>
              <td>{{ $row->continentRef?->continent_value }}</td>
              <td>{{ $row->verbatimSrsRef?->verbatimSRS_value }}</td>
              <td>{{ $row->georefStatusRef?->georef_status_value }}</td>
              <td class="text-nowrap">
               
                {{-- Tabla de eventos de esta location --}}
                @if($row->events->isEmpty())
                  <a href="{{ route('event.create', ['location' => $row->locationID]) }}"
                    class="btn btn-sm btn-outline-primary">
                    Event +
                  </a><br/>
                  <div class="text-muted mt-2">Sin eventos para esta ubicación.</div>
                @else
                  <table class="table table-sm table-bordered mt-2">
                    <thead>
                      <tr>
                        {{-- <th>Fecha</th>
                        <th>Hora</th> --}}
                        @if($row->events_count == 0)
                        <th><a href="{{ route('event.create', ['location' => $row->locationID]) }}"
                              class="btn btn-sm btn-outline-primary">
                              Event +
                            </a><br/>
                        </th>
                        @endif    
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($row->events as $ev)
                        <tr>
                          <td><span style="font-size:13px">{{ $ev->fieldNotes}}</span>
                            <a href="{{ route('event.show', $ev->eventID) }}" class="btn btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('event.edit', $ev->eventID) }}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
                            <form style="display:inline" method="POST" action="{{ route('event.destroy', $ev) }}" onsubmit="return confirm('¿Eliminar?')">
                              @csrf @method('DELETE')
                              <button class="btn ghost " type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endif
                
              </td>
              <td class="text-center">
                <a href="{{ route('location.show',['location' => $row->locationID, 'page' => $page]) }}" class="btn"><i class="fa fa-eye"></i></a>
                <a href="{{ route('location.edit',['location' => $row->locationID, 'page' => $page]) }}" class="btn"><i class="fa fa-edit"></i></a>
                <form action="{{ route('location.destroy', ['location' => $row ?? $location, 'page' => $page]) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este registro?')">
                  @csrf @method('DELETE')
                  <input type="hidden" name="page" value="{{ $page }}">
                  <button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
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
