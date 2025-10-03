@extends('layouts.sidebar')
@section('page_title','Detalle — Tblextracciones')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Tblextracciones #{ $item->idExtracciones }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Idextracciones</dt>
      <dd class="col-sm-8">{{ $item->idExtracciones }}</dd>
      <dt class="col-sm-4">Id occ bd</dt>
      <dd class="col-sm-8">{{ $item->id_occ_bd }}</dd>
      <dt class="col-sm-4">Materialsampletype</dt>
      <dd class="col-sm-8">{{ $item->materialSampleType }}</dd>
      <dt class="col-sm-4">Idregistros</dt>
      <dd class="col-sm-8">{{ $item->idRegistros }}</dd>
      <dt class="col-sm-4">Fechaextraccion</dt>
      <dd class="col-sm-8">{{ $item->fechaExtraccion }}</dd>
      <dt class="col-sm-4">Purificationmethod</dt>
      <dd class="col-sm-8">{{ $item->purificationMethod }}</dd>
      <dt class="col-sm-4">Methoddeterminationconcentrationandratios</dt>
      <dd class="col-sm-8">{{ $item->methodDeterminationConcentrationAndRatios }}</dd>
      <dt class="col-sm-4">Adn enstock</dt>
      <dd class="col-sm-8">{{ $item->adn_enSTOCK }}</dd>
      <dt class="col-sm-4">Volume</dt>
      <dd class="col-sm-8">{{ $item->volume }}</dd>
      <dt class="col-sm-4">Volumeunit</dt>
      <dd class="col-sm-8">{{ $item->volumeUnit }}</dd>
      <dt class="col-sm-4">Concentration</dt>
      <dd class="col-sm-8">{{ $item->concentration }}</dd>
      <dt class="col-sm-4">Concentrationunit</dt>
      <dd class="col-sm-8">{{ $item->concentrationUnit }}</dd>
      <dt class="col-sm-4">Ratioofabsorbance260 280</dt>
      <dd class="col-sm-8">{{ $item->ratioOfAbsorbance260_280 }}</dd>
      <dt class="col-sm-4">Ratioofabsorbance260 230</dt>
      <dd class="col-sm-8">{{ $item->ratioOfAbsorbance260_230 }}</dd>
      <dt class="col-sm-4">Preservationtype</dt>
      <dd class="col-sm-8">{{ $item->preservationType }}</dd>
      <dt class="col-sm-4">Preservationtemperature</dt>
      <dd class="col-sm-8">{{ $item->preservationTemperature }}</dd>
      <dt class="col-sm-4">Preservationdatebegin</dt>
      <dd class="col-sm-8">{{ $item->preservationDateBegin }}</dd>
      <dt class="col-sm-4">Quality</dt>
      <dd class="col-sm-8">{{ $item->quality }}</dd>
      <dt class="col-sm-4">Qualitycheckdate</dt>
      <dd class="col-sm-8">{{ $item->qualityCheckDate }}</dd>
      <dt class="col-sm-4">Sieving</dt>
      <dd class="col-sm-8">{{ $item->sieving }}</dd>
      <dt class="col-sm-4">Codigomuestrabiobanco</dt>
      <dd class="col-sm-8">{{ $item->codigoMuestraBiobanco }}</dd>
      <dt class="col-sm-4">Codigoadnbiobanco</dt>
      <dd class="col-sm-8">{{ $item->codigoADNBiobanco }}</dd>
      <dt class="col-sm-4">Codigogermoplasmabiobanco</dt>
      <dd class="col-sm-8">{{ $item->codigoGermoplasmaBiobanco }}</dd>
      <dt class="col-sm-4">Extractionstaff</dt>
      <dd class="col-sm-8">{{ $item->extractionStaff }}</dd>
      <dt class="col-sm-4">Qualityremarks</dt>
      <dd class="col-sm-8">{{ $item->qualityRemarks }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('occurrence.index') }}">Volver</a>
      <a class="btn" href="{{ route('tbl-extractions.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
