@extends('layouts.sidebar')

@section('title','Location — Detalle')
@section('page_title','Detalle Location')

@section('content')
  <div class="card">
    <div class="card-body">
      <dl class="row">
        <dt class="col-md-3">Location ID</dt>
        <dd class="col-md-9">{{ $item->locationID }}</dd>

        <dt class="col-md-3">Locality</dt>
        <dd class="col-md-9">{{ $item->locality }}</dd>

        <dt class="col-md-3">Country</dt>
        <dd class="col-md-9">{{ $item->country }} @if($item->countryCode) ({{ $item->countryCode }}) @endif</dd>

        <dt class="col-md-3">State/Province</dt>
        <dd class="col-md-9">{{ $item->stateProvince }}</dd>

        <dt class="col-md-3">Continent</dt>
        <dd class="col-md-9">{{ $item->continentRef?->continent_value }}</dd>

        <dt class="col-md-3">Verbatim SRS</dt>
        <dd class="col-md-9">{{ $item->verbatimSrsRef?->verbatimSRS_value }}</dd>

        <dt class="col-md-3">Georef. Status</dt>
        <dd class="col-md-9">{{ $item->georefStatusRef?->georef_status_value }}</dd>

        <dt class="col-md-3">Coords</dt>
        <dd class="col-md-9">
          Lat: {{ $item->decimalLatitude ?? '—' }},
          Lng: {{ $item->decimalLongitude ?? '—' }}
        </dd>

        <dt class="col-md-3">Remarks</dt>
        <dd class="col-md-9">{{ $item->locationRemarks }}</dd>
      </dl>

      <div class="d-flex gap-2 btnForms">
        @if(auth()->user()->is_admin)
          <a href="{{ route('location.edit',$item->locationID) }}" class="btn btn-primary">Editar</a>
        @endif
        <a href="{{ route('location.index') }}" class="btn btn-light">Volver</a>
      </div>
    </div>
  </div>
@endsection
