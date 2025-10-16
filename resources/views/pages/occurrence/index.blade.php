@extends('layouts.sidebar')

@section('title','Occurrence — Listado')
@section('page_title','Occurrence')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="m-0">Listado</h6>
    <a href="{{ route('occurrence.create-wizard') }}" class="btn btn-secondary btn-sm">Nuevo</a>

  </div>

  <form method="GET" action="{{ route('occurrence.index') }}" class="mb-2 d-flex gap-2">
    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar...">
    <input type="hidden" name="per_page" value="{{ $perPage }}">
    <button class="btn btn-primary">Buscar</button>
    <a href="{{ route('occurrence.index', ['clear' => 1]) }}"
      class="btn btn-outline-secondary">Limpiar</a>
  </form>

  <form method="GET" action="{{ route('occurrence.index') }}" class="mb-3 d-flex align-items-center gap-2">
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

  <div class="card-body">
    @if($items->count())
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>OccurrenceID</th>
              <th>Record level</th>
              <th>Catalog #</th>
              <th>Recorded by</th>
             {{--  <th>Ind. count</th>
              <th>OQ Type</th>
              <th>Sex</th> --}}
              <th>Life stage</th>
              {{-- <th>Repro. cond.</th> --}}
              {{-- <th>Estab. means</th> --}}
              <th>Disposition</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @php $page = $items->currentPage() ?? old('page', request('page', 1)); @endphp
            @foreach($items as $row)
              <tr>
                <td>{{ $row->id_occ_bd }}</td>
                <td>{{ $row->occurrenceID }}</td>
                <td>{{ $row->recordLevelRef?->record_level_id }}</td>
                <td>{{ $row->catalogNumber }}</td>
                <td>{{ $row->recordedBy }}</td>
                {{-- <td>{{ $row->individualCount }}</td>
                <td>{{ $row->organismQuantityTypeRef?->oqtype_value }}</td>
                <td>{{ $row->sexRef?->sex_value }}</td> --}}
                <td>{{ $row->lifeStageRef?->lifestage_value }}</td>
                {{-- <td>{{ $row->reproductiveConditionRef?->reprocond_value }}</td> --}}
               {{--  <td>{{ $row->establishmentMeansRef?->estabmeans_value }}</td> --}}
                {{-- <td>{{ $row->dispositionRef?->disposition_value }}</td> --}}
                <td class="text-nowrap">
                  
                  {{-- measurements --}}
                  @if($row->measurements->isEmpty())
                    <a href="{{ route('measurement-or-facts.create', ['occurrence' => $row->id_occ_bd]) }}"
                      class="btn btn-sm btn-outline-primary">
                      Measurement +
                    </a><br/>
                    <div class="text-muted mt-2">Sin Measurement.</div>
                  @else
                    <table class="table table-sm table-bordered mt-2">
                      <thead>
                        <tr>
                          <th><a href="{{ route('measurement-or-facts.create', ['occurrence' => $row->id_occ_bd]) }}"
                            class="btn btn-sm btn-outline-primary">
                            Measurement +
                          </a><br/>
                          </th>    
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($row->measurements as $ev)
                          <tr>
                            <td><span style="font-size:13px">{{ $ev->measurementID}}</span>
                              <a href="{{ route('measurement-or-facts.show', $ev->measurementID) }}" class="btn btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="{{ route('measurement-or-facts.edit', $ev->measurementID) }}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('measurement-or-facts.destroy',$ev->measurementID) }}" method="POST" class="d-inline"
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

                  {{-- multimedia --}}
                  @if($row->multimedia->isEmpty())
                    <a href="{{ route('tbl-multimedia.create', ['occurrence' => $row->id_occ_bd]) }}"
                      class="btn btn-sm btn-outline-primary">
                      Multimedia ++
                    </a><br/>
                    <div class="text-muted mt-2">Sin multimedia.</div>
                  @else
                    <table class="table table-sm table-bordered mt-2">
                      <thead>
                        <tr>
                          <th> <a href="{{ route('tbl-multimedia.create', ['occurrence' => $row->id_occ_bd]) }}"
                              class="btn btn-sm btn-outline-primary">
                              Multimedia ++
                            </a><br/>
                          </th>    
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($row->multimedia as $ev)
                          <tr>
                            <td><span style="font-size:13px">{{ $ev->idMultimedia}}</span>
                              <a href="{{ route('tbl-multimedia.show', $ev->idMultimedia) }}" class="btn btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="{{ route('tbl-multimedia.edit', $ev->idMultimedia) }}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('tbl-multimedia.destroy',$ev->idMultimedia) }}" method="POST" class="d-inline"
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
                  
                  {{-- extractions --}}
                  @if($row->extractions->isEmpty())
                    <a href="{{ route('tbl-extractions.create', ['occurrence' => $row->id_occ_bd]) }}"
                      class="btn btn-sm btn-outline-primary">
                      Extractions +
                    </a><br/>
                    <div class="text-muted mt-2">Sin extracciones.</div>
                  @else
                    <table class="table table-sm table-bordered mt-2">
                      <thead>
                        <tr>
                          <th> <a href="{{ route('tbl-extractions.create', ['occurrence' => $row->id_occ_bd]) }}"
                            class="btn btn-sm btn-outline-primary">
                            Extractions +
                          </a><br/>
                          </th>    
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($row->extractions as $ev)
                          <tr>
                            <td><span style="font-size:13px">{{ $ev->idExtracciones}}</span>
                              <a href="{{ route('tbl-extractions.show', $ev->idExtracciones) }}" class="btn btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="{{ route('tbl-extractions.edit', $ev->idExtracciones) }}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('tbl-extractions.destroy',$ev->idExtracciones) }}" method="POST" class="d-inline"
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
                 
                  {{-- <a href="{{ route('occurrence.edit',$row) }}" class="btn btn-sm btn-primary">Multimedia</a><br/> --}}
                  {{-- <a href="{{ route('occurrence.edit',$row) }}" class="btn btn-sm btn-primary">Extractions</a><br/> --}}
                </td>
                <td class="text-nowrap">
                  <a href="{{ route('occurrence.show',['occurrence' => $row->id_occ_bd, 'page' => $page]) }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a><br/>
                  <a href="{{ route('occurrence.edit',['occurrence' => $row->id_occ_bd, 'page' => $page]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a><br/>
                  <form action="{{ route('occurrence.destroy',['occurrence' => $row ?? $occurrence, 'page' => $page]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro?')">
                    @csrf @method('DELETE')
                    <input type="hidden" name="page" value="{{ $page }}">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($items->hasPages())
        <div class="mt-3">{{{ $items->links() }}}</div>
      @endif
    @else
      <p class="mb-0">No hay registros.</p>
    @endif
  </div>
</div>
@endsection
