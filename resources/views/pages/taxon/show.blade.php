@extends('layouts.sidebar')

@section('title','Taxon — Detalle')
@section('page_title','Detalle Taxon')

@php $page = request('page', 1); @endphp

@section('content')
  <div class="card">
    <div class="card-body btnForms">
      <dl class="row">
        <dt class="col-md-3">Taxon ID</dt>
        <dd class="col-md-9">{{ $item->taxonID }}</dd>

        <dt class="col-md-3">Scientific Name ID</dt>
        <dd class="col-md-9">{{ $item->scientificNameID }}</dd>

        <dt class="col-md-3">Scientific Name</dt>
        <dd class="col-md-9">{{ $item->scientificName }}</dd>

        <dt class="col-md-3">Name Published In</dt>
        <dd class="col-md-9">{{ $item->namePublishedIn }}</dd>

        <dt class="col-md-3">Name Published In Year</dt>
        <dd class="col-md-9">{{ $item->namePublishedInYear }}</dd>

        <dt class="col-md-3">Higher Classification</dt>
        <dd class="col-md-9">{{ $item->higherClassification }}</dd>

        <dt class="col-md-3">Taxon Rank</dt>
        <dd class="col-md-9">{{ $item->taxonRankRef?->taxonRank_value }} @if($item->verbatimTaxonRank) ({{ $item->verbatimTaxonRank }}) @endif</dd>

        <dt class="col-md-3">Scientific Name Authorship</dt>
        <dd class="col-md-9">{{ $item->scientificNameAuthorship }}</dd>

        <dt class="col-md-3">Vernacular Name</dt>
        <dd class="col-md-9">{{ $item->vernacularName }}</dd>

        <dt class="col-md-3">Taxonomic Status</dt>
        <dd class="col-md-9">{{ $item->taxonomicStatusRef?->taxonomicStatus_value }}</dd>

        <dt class="col-md-3">Kingdom / Phylum / Class</dt>
        <dd class="col-md-9">{{ $item->kingdom }} / {{ $item->phylum }} / {{ $item->class }}</dd>

        <dt class="col-md-3">Order / Family / Genus / Subgenus</dt>
        <dd class="col-md-9">{{ $item->order }} / {{ $item->family }} / {{ $item->genus }} / {{ $item->subgenus }}</dd>

        <dt class="col-md-3">Specific / Intraspecific Epithet</dt>
        <dd class="col-md-9">{{ $item->specificEpithet }} / {{ $item->intraspecificEpithet }}</dd>

        <dt class="col-md-3">Taxon Remarks</dt>
        <dd class="col-md-9">{{ $item->taxonRemarks }}</dd>
      </dl>

      <div class="d-flex gap-2">
        <a href="{{ route('taxon.index',['page'=>$page]) }}" class="btn btn-light">Volver</a>
        <a href="{{ route('taxon.edit',['taxon'=>$item->taxonID, 'page'=>$page]) }}" class="btn btn-primary">Editar</a>
      </div>
    </div>
  </div>
@endsection
