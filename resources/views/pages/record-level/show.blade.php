@extends('layouts.sidebar')

@section('title','Record Level — Detalle')
@section('page_title','Detalle Record Level')

@section('content')
<div class="card card-body">
  <dl class="row">
    <dt class="col-sm-3">ID</dt>
    <dd class="col-sm-9">{{ $item->record_level_id }}</dd>

    <dt class="col-sm-3">Type</dt>
    <dd class="col-sm-9">{{ $item->typeRef?->type_value }}</dd>

    <dt class="col-sm-3">License</dt>
    <dd class="col-sm-9">{{ $item->licenseRef?->license_value }}</dd>

    <dt class="col-sm-3">Rights holder</dt>
    <dd class="col-sm-9">{{ $item->rightsHolderRef?->rightsHolder_value }}</dd>

    <dt class="col-sm-3">Access rights</dt>
    <dd class="col-sm-9">{{ $item->accessRightsRef?->accessrights_value }}</dd>

    <dt class="col-sm-3">InstitutionID</dt>
    <dd class="col-sm-9">{{ $item->institutionIdRef?->institutionID_value }}</dd>

    <dt class="col-sm-3">CollectionID</dt>
    <dd class="col-sm-9">{{ $item->collectionIdRef?->collection_value }}</dd>

    <dt class="col-sm-3">Institution code</dt>
    <dd class="col-sm-9">{{ $item->institutionCodeRef?->institutionCode_value }}</dd>

    <dt class="col-sm-3">Collection code</dt>
    <dd class="col-sm-9">{{ $item->collectionCodeRef?->collectionCode_value }}</dd>

    <dt class="col-sm-3">Owner inst. code</dt>
    <dd class="col-sm-9">{{ $item->ownerInstitutionCodeRef?->ownerinstitutioncode_value }}</dd>

    <dt class="col-sm-3">Basis of record</dt>
    <dd class="col-sm-9">{{ $item->basisOfRecordRef?->basisofrecord_value }}</dd>

    <dt class="col-sm-3">Language</dt>
    <dd class="col-sm-9">{{ $item->language }}</dd>

    <dt class="col-sm-3">Modified</dt>
    <dd class="col-sm-9">{{ optional($item->modified)->format('Y-m-d H:i') }}</dd>

    <dt class="col-sm-3">Dataset ID</dt>
    <dd class="col-sm-9">{{ $item->datasetID }}</dd>

    <dt class="col-sm-3">Dataset Name</dt>
    <dd class="col-sm-9">{{ $item->datasetName }}</dd>

    <dt class="col-sm-3">Bibliographic citation</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->bibliographicCitation }}</pre></dd>

    <dt class="col-sm-3">References</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->references }}</pre></dd>

    <dt class="col-sm-3">Information withheld</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->informationWithheld }}</pre></dd>

    <dt class="col-sm-3">Data generalizations</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->dataGeneralizations }}</pre></dd>
  </dl>

  <div class="mt-2">
    <a class="btn btn-outline-secondary" href="{{ route('record-level.index') }}">Volver</a>
    <a class="btn btn-primary" href="{{ route('record-level.edit',$item) }}">Editar</a>
  </div>
</div>
@endsection
