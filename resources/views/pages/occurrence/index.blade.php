@extends('layouts.sidebar')

@section('title','Occurrence — Listado')
@section('page_title','Occurrence')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="m-0">Listado</h6>
    <a href="{{ route('occurrence.create-wizard') }}" class="btn btn-secondary btn-sm">Nuevo</a>

  </div>

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
              <th>Ind. count</th>
              <th>OQ Type</th>
              <th>Sex</th>
              <th>Life stage</th>
              <th>Repro. cond.</th>
              <th>Estab. means</th>
              <th>Disposition</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $row)
              <tr>
                <td>{{ $row->id_occ_bd }}</td>
                <td>{{ $row->occurrenceID }}</td>
                <td>{{ $row->recordLevelRef?->record_level_id }}</td>
                <td>{{ $row->catalogNumber }}</td>
                <td>{{ $row->recordedBy }}</td>
                <td>{{ $row->individualCount }}</td>
                <td>{{ $row->organismQuantityTypeRef?->oqtype_value }}</td>
                <td>{{ $row->sexRef?->sex_value }}</td>
                <td>{{ $row->lifeStageRef?->lifestage_value }}</td>
                <td>{{ $row->reproductiveConditionRef?->reprocond_value }}</td>
                <td>{{ $row->establishmentMeansRef?->estabmeans_value }}</td>
                {{-- <td>{{ $row->dispositionRef?->disposition_value }}</td> --}}
                <td class="text-nowrap">
                 {{--  <a href="{{ route('occurrence.edit',$row) }}" class="btn btn-sm btn-primary">MeasureMF</a><br/> --}}


                  <a href="{{ route('measurement-or-facts.create', ['occurrence' => $row->id_occ_bd]) }}"
                    class="btn btn-sm btn-outline-primary">
                    Measurement +
                  </a><br/>

                  <a href="{{ route('tbl-multimedia.create', ['occurrence' => $row->id_occ_bd]) }}"
                    class="btn btn-sm btn-outline-primary">
                    Multimedia +
                  </a><br/>

                   <a href="{{ route('tbl-extractions.create', ['occurrence' => $row->id_occ_bd]) }}"
                    class="btn btn-sm btn-outline-primary">
                    Extractions +
                  </a><br/>

                  {{-- <a href="{{ route('occurrence.edit',$row) }}" class="btn btn-sm btn-primary">Multimedia</a><br/> --}}
                  {{-- <a href="{{ route('occurrence.edit',$row) }}" class="btn btn-sm btn-primary">Extractions</a><br/> --}}
                </td>
                <td class="text-nowrap">
                  <a href="{{ route('occurrence.show',$row) }}" class="btn btn-sm btn-outline-secondary">Ver</a><br/>
                  <a href="{{ route('occurrence.edit',$row) }}" class="btn btn-sm btn-primary">Editar</a><br/>
                  <form action="{{ route('occurrence.destroy',$row) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
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
