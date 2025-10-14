@extends('layouts.sidebar')

@section('title','Location — Detalle')
@section('page_title','Detalle Location')

@php $page = request('page', 1); @endphp

@section('content')
  <div class="card">
    <div class="card-body">
      <dl class="row">

        <dt class="col-md-3">Location ID</dt>
        <dd class="col-md-9">{{ $item->locationID }}</dd>
        
        <dt class="col-md-3">id_INEC</dt>
        <dd class="col-md-9">{{ $item->id_INEC }}</dd>
        
        <dt class="col-md-3">higherGeographyID</dt>
        <dd class="col-md-9">{{ $item->higherGeographyID }}</dd>

        <dt class="col-md-3">Continent</dt>
        <dd class="col-md-9">{{ $item->continentRef?->continent_value }}</dd>
        
        <dt class="col-md-3">waterBody</dt>
        <dd class="col-md-9">{{ $item->waterBody }}</dd>
        
        <dt class="col-md-3">islandGroup</dt>
        <dd class="col-md-9">{{ $item->islandGroup }}</dd>
        
        <dt class="col-md-3">island</dt>
        <dd class="col-md-9">{{ $item->island }}</dd>

        <dt class="col-md-3">Country</dt>
        <dd class="col-md-9">{{ $item->country }} @if($item->country) @endif</dd>
        
        <dt class="col-md-3">countryCode</dt>
        <dd class="col-md-9">{{ $item->countryCode }} @if($item->countryCode) @endif</dd>

        <dt class="col-md-3">State/Province</dt>
        <dd class="col-md-9">{{ $item->stateProvince }}</dd>
        
        <dt class="col-md-3">County</dt>
        <dd class="col-md-9">{{ $item->county }}</dd>
        
        <dt class="col-md-3">Municipality</dt>
        <dd class="col-md-9">{{ $item->municipality }}</dd>

        <dt class="col-md-3">Locality</dt>
        <dd class="col-md-9">{{ $item->locality }}</dd>

        <dt class="col-md-3">VerbatimLocality</dt>
        <dd class="col-md-9">{{ $item->verbatimLocality }}</dd>

        <dt class="col-md-3">VerbatimElevation</dt>
        <dd class="col-md-9">{{ $item->verbatimElevation }}</dd>

        <dt class="col-md-3">VerbatimDepth</dt>
        <dd class="col-md-9">{{ $item->verbatimDepth }}</dd>
         
        <dt class="col-md-3">LocationRemarks</dt>
        <dd class="col-md-9">{{ $item->locationRemarks }}</dd>
        
        <dt class="col-md-3">DecimalLatitude</dt>
        <dd class="col-md-9">{{ $item->decimalLatitude }}</dd>
        
        <dt class="col-md-3">DecimalLongitude</dt>
        <dd class="col-md-9">{{ $item->decimalLongitude }}</dd>
        
        <dt class="col-md-3">GeodeticDatum</dt>
        <dd class="col-md-9">{{ $item->geodeticDatum }}</dd>

        <dt class="col-md-3">VerbatimLatitude</dt>
        <dd class="col-md-9">{{ $item->verbatimLatitude }}</dd>

        <dt class="col-md-3">VerbatimLongitude</dt>
        <dd class="col-md-9">{{ $item->verbatimLongitude }}</dd>
        
        <dt class="col-md-3">VerbatimCoordinateSystem</dt>
        <dd class="col-md-9">{{ $item->verbatimCoordinateSystem }}</dd>

        <dt class="col-md-3">VerbatimSRS</dt>
        <dd class="col-md-9">{{ $item->verbatimSRS }}</dd>

        <dt class="col-md-3">GeoreferencedBy</dt>
        <dd class="col-md-9">{{ $item->georeferencedBy }}</dd>

        <dt class="col-md-3">GeoreferencedDate</dt>
        <dd class="col-md-9">{{ $item->georeferencedDate }}</dd>

        <dt class="col-md-3">GeoreferenceVerificationStatus</dt>
        <dd class="col-md-9">{{ $item->georeferenceVerificationStatus }}</dd>

        <dt class="col-md-3">GeoreferenceRemarks</dt>
        <dd class="col-md-9">{{ $item->georeferenceRemarks }}</dd>
        
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
        <a href="{{ route('location.index',['location'=>$item->locationID, 'page'=>$page]) }}" class="btn btn-light">Volver</a>
        @if(auth()->user()->is_admin)
          {{-- <a href="{{ route('location.edit',$item->locationID) }}" class="btn btn-primary">Editar</a> --}}
          <a href="{{ route('location.edit',['location'=>$item->locationID, 'page'=>$page]) }}" class="btn btn-primary">Editar</a>
        @endif
      </div>
    </div>
  </div>
@endsection
