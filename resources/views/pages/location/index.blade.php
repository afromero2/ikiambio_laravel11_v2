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

  <form method="GET" action="{{ route('location.index') }}" class="mb-2 d-flex gap-2">
    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar...">
    <input type="hidden" name="per_page" value="{{ $perPage }}">
    <button class="btn btn-primary">Buscar</button>
    <a href="{{ route('location.index', ['clear' => 1]) }}"
      class="btn btn-outline-secondary">Limpiar</a>
  </form>

  <form method="GET" action="{{ route('location.index') }}" class="mb-3 d-flex align-items-center gap-2">
    {{-- preserva q al cambiar per_page --}}
    <input type="hidden" name="q" value="{{ $q }}">
    <label class="form-label m-0">Mostrar</label>
    <select name="per_page" class="form-select w-auto" onchange="this.form.submit()">
      @foreach($allowed as $size)
        <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }}</option>
      @endforeach
    </select>
    <span>por página</span>
  </form>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>locationID</th>
            <th>higherGeographyID</th>
            <th>country</th>
            <th>stateProvince</th>
            <th>municipality</th>
            <th>locality</th>
            <th>verbatimLocality</th>
            <th class="text-center">Eventos asociados</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @php $page = $items->currentPage() ?? old('page', request('page', 1)); @endphp
          @forelse($items as $row)
            <tr>
              <td>{{ $row->locationID }}</td>
              <td>{{ $row->higherGeographyID }}</td>
              <td>{{ $row->country }}</td>
              <td>{{ $row->stateProvince }}</td>
              <td>{{ $row->municipality }}</td>
              <td>{{ $row->locality }}</td>
              <td>{{ $row->verbatimLocality }}</td>
              <td class="text-nowrap">
               
                {{-- Tabla de eventos de esta location --}}
                @if($row->events->isEmpty())
                  <a href="{{ route('event.create', ['location' => $row->locationID, 'page' => $page]) }}"
                    class="btn btn-sm btn-outline-primary">
                    Event +
                  </a><br/>
                  <div class="text-muted mt-2">Sin eventos asociados.</div>
                @else
                  <table class="table table-sm table-bordered mt-2">
                    <thead>
                      <tr>
                        {{-- <th>Fecha</th>
                        <th>Hora</th> --}}
                       {{--  @if($row->events_count == 0)
                        <th><a href="{{ route('event.create', ['location' => $row->locationID]) }}"
                              class="btn btn-sm btn-outline-primary">
                              Event +
                            </a><br/>
                        </th>
                        @endif  --}}   
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($row->events as $ev)
                        <tr>
                          <td><span style="font-size:13px">{{ $ev->fieldNotes}}</span>
                            <a href="{{ route('event.show', ['event' => $ev->eventID, 'page' => $page]) }}" class="btn btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('event.edit', ['event' => $ev->eventID, 'page' => $page]) }}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
                            
                            <form style="display:inline" method="POST" action="{{ route('event.destroy', ['event' => $ev ?? $event, 'page' => $page]) }}" onsubmit="return confirm('¿Eliminar?')">
                              @csrf @method('DELETE')
                              <input type="hidden" name="page" value="{{ $page }}">
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
