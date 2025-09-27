@extends('layouts.sidebar')

@section('title','Record Level — Listado')
@section('page_title','Record Level')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="m-0">Listado</h6>
    <a href="{{ route('record-level.create') }}" class="btn btn-primary btn-sm">Nuevo</a>
  </div>

  <div class="card-body">
    @if($items->count())
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Type</th>
              <th>License</th>
              <th>Rights holder</th>
              <th>Access rights</th>
             {{--  <th>InstitutionID</th>
              <th>CollectionID</th>
              <th>Inst. Code</th>
              <th>Coll. Code</th>
              <th>Owner Inst.</th> --}}
              <th>Basis of record</th>
              <th>Language</th>
              <th>Modified</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          @foreach($items as $row)
            <tr>
              <td>{{ $row->record_level_id }}</td>
              <td>{{ $row->typeRef?->type_value }}</td>
              <td>{{ $row->licenseRef?->license_value }}</td>
              <td>{{ $row->rightsHolderRef?->rightsHolder_value }}</td>
              <td>{{ $row->accessRightsRef?->accessrights_value }}</td>
             {{--  <td>{{ $row->institutionIdRef?->institutionID_value }}</td>
              <td> {{ $row->collectionIdRef?->collection_value }}</td>
              <td>{{ $row->institutionCodeRef?->institutionCode_value }}</td>
              <td>{{ $row->collectionCodeRef?->collectionCode_value }}</td>
              <td>{{ $row->ownerInstitutionCodeRef?->ownerinstitutioncode_value }}</td> --}}
              <td>{{ $row->basisOfRecordRef?->basisofrecord_value }}</td>
                            <td>{{ $row->language }}</td>
              <td>{{ optional($row->modified)->format('Y-m-d H:i') }}</td>
              <td class="text-nowrap">
                <a href="{{ route('record-level.show',$row) }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                <a href="{{ route('record-level.edit',$row) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <form action="{{ route('record-level.destroy',$row) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro?')">
                  @csrf @method('DELETE')
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
