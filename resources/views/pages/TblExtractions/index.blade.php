@extends('layouts.sidebar')
@section('page_title','TblExtractions')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">TblExtractions</h1>
  <a href="{{ route('tbl-extractions.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr> 
            <th>Idextracciones</th>
            <th>Id occ bd</th>
            <th>Materialsampletype</th>
            <th>Idregistros</th>
           {{--  <th>Fechaextraccion</th>
            <th>Purificationmethod</th> --}}
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->idExtracciones }}</td>
            <td>{{ $item->id_occ_bd }}</td>
            <td>{{ $item->materialSampleType }}</td>
            <td>{{ $item->idRegistros }}</td>
           {{--  <td>{{ $item->fechaExtraccion }}</td>
            <td>{{ $item->purificationMethod }}</td> --}}

            <td class="text-nowrap">
               
                {{-- Tabla de eventos de esta location --}}
                @if($item->regLaboratorio->isEmpty())
                  <a href="{{ route('tbl-registros-laboratorio.create', ['idExtracciones' => $item->idExtracciones]) }}"
                    class="btn btn-sm btn-outline-primary">
                    Registro laboratorio +
                  </a><br/>
                  <div class="text-muted mt-2">Sin registro laboratorio para esta extración.</div>
                @else
                  <table class="table table-sm table-bordered mt-2">
                    <thead>
                      <tr>
                        {{-- <th>Fecha</th>
                        <th>Hora</th> --}}
                        <a href="{{ route('tbl-registros-laboratorio.create', ['idExtracciones' => $item->idExtracciones]) }}"
                              class="btn btn-sm btn-outline-primary">
                              Registro laboratorio +
                            </a><br/>
                        </th>    
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($item->regLaboratorio as $rl)
                        <tr>
                          <td><span style="font-size:13px">{{ $rl->idExtracciones }}</span>
                           
                            <a href="{{ route('tbl-registros-laboratorio.show', $rl) }}"
                              class="btn btn-sm" title="Ver">
                              <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('tbl-registros-laboratorio.edit', $rl) }}"
                              class="btn btn-sm" title="Editar">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('tbl-registros-laboratorio.destroy',$rl) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este registro?')">
                              @csrf @method('DELETE')
                              <button class="btn btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endif
                
              </td>

            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('tbl-extractions.show', $item) }}"><i class="fa fa-eye"></i></a>
              <a class="btn ghost" href="{{ route('tbl-extractions.edit', $item) }}"><i class="fa fa-edit"></i></a>
              <form style="display:inline" method="POST" action="{{ route('tbl-extractions.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button class="btn ghost " type="submit"><i class="fa fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="text-align:center;color:#6b7280;padding:20px;">Sin registros</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div style="margin-top:12px;">
  {{ $items->links() }}
</div>
@endsection
