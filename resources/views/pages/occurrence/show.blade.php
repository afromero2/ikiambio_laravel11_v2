@extends('layouts.sidebar')

@section('title','Occurrence — Detalle')
@section('page_title','Detalle Occurrence')

@section('content')
<div class="card card-body">
  <dl class="row">
    <dt class="col-sm-3">ID</dt>
    <dd class="col-sm-9">{{ $item->id_occ_bd }}</dd>

    <dt class="col-sm-3">OccurrenceID</dt>
    <dd class="col-sm-9">{{ $item->occurrenceID }}</dd>

    <dt class="col-sm-3">Record level</dt>
    <dd class="col-sm-9">{{ $item->recordLevelRef?->record_level_id }}</dd>

    <dt class="col-sm-3">Catalog Number</dt>
    <dd class="col-sm-9">{{ $item->catalogNumber }}</dd>

    <dt class="col-sm-3">Record Number</dt>
    <dd class="col-sm-9">{{ $item->recordNumber }}</dd>

    <dt class="col-sm-3">Recorded By</dt>
    <dd class="col-sm-9">{{ $item->recordedBy }}</dd>

    <dt class="col-sm-3">Individual Count</dt>
    <dd class="col-sm-9">{{ $item->individualCount }}</dd>

    <dt class="col-sm-3">Organism Quantity</dt>
    <dd class="col-sm-9">{{ $item->organismQuantity }}</dd>

    <dt class="col-sm-3">OQ Type</dt>
    <dd class="col-sm-9">{{ $item->organismQuantityTypeRef?->oqtype_value }}</dd>

    <dt class="col-sm-3">Sex</dt>
    <dd class="col-sm-9">{{ $item->sexRef?->sex_value }}</dd>

    <dt class="col-sm-3">Life stage</dt>
    <dd class="col-sm-9">{{ $item->lifeStageRef?->lifestage_value }}</dd>

    <dt class="col-sm-3">Reproductive condition</dt>
    <dd class="col-sm-9">{{ $item->reproductiveConditionRef?->reprocond_value }}</dd>

    <dt class="col-sm-3">Establishment means</dt>
    <dd class="col-sm-9">{{ $item->establishmentMeansRef?->estabmeans_value }}</dd>

    <dt class="col-sm-3">Disposition</dt>
    <dd class="col-sm-9">{{ $item->dispositionRef?->disposition_value }}</dd>

    <dt class="col-sm-3">Organism ID</dt>
    <dd class="col-sm-9">{{ $item->organismID }}</dd>

    <dt class="col-sm-3">Location ID</dt>
    <dd class="col-sm-9">{{ $item->locationID }}</dd>

    <dt class="col-sm-3">Taxon ID</dt>
    <dd class="col-sm-9">{{ $item->taxonID }}</dd>

    <dt class="col-sm-3">Identification ID</dt>
    <dd class="col-sm-9">{{ $item->identificationID }}</dd>

    <dt class="col-sm-3">Behavior</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->behavior }}</pre></dd>

    <dt class="col-sm-3">Substrate</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->substrate }}</pre></dd>

    <dt class="col-sm-3">Preparations</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->preparations }}</pre></dd>

    <dt class="col-sm-3">Associated media</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->associatedMedia }}</pre></dd>

    <dt class="col-sm-3">Associated sequences</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->associatedSequences }}</pre></dd>

    <dt class="col-sm-3">Associated taxa</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->associatedTaxa }}</pre></dd>

    <dt class="col-sm-3">Other catalog numbers</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->otherCatalogNumbers }}</pre></dd>

    <dt class="col-sm-3">Occurrence remarks</dt>
    <dd class="col-sm-9"><pre class="mb-0">{{ $item->occurrenceRemarks }}</pre></dd>
  </dl>

  <div class="mt-2">
    <a class="btn btn-outline-secondary" href="{{ route('occurrence.index') }}">Volver</a>
    <a class="btn btn-primary" href="{{ route('occurrence.edit',$item) }}">Editar</a>
  </div>
</div>
@endsection
