@extends('layouts.sidebar')
@section('page_title','Detalle — Tblregistroslaboratorio')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Tblregistroslaboratorio #{ $item->idRegistrosLaboratorio }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Idregistroslaboratorio</dt>
      <dd class="col-sm-8">{{ $item->idRegistrosLaboratorio }}</dd>
      <dt class="col-sm-4">Idfechapcr</dt>
      <dd class="col-sm-8">{{ $item->idFechaPCR }}</dd>
      <dt class="col-sm-4">Idextracciones</dt>
      <dd class="col-sm-8">{{ $item->idExtracciones }}</dd>
      <dt class="col-sm-4">Vol adn pcr</dt>
      <dd class="col-sm-8">{{ $item->vol_ADN_PCR }}</dd>
      <dt class="col-sm-4">Amplificationsuccess</dt>
      <dd class="col-sm-8">{{ $item->amplificationSuccess }}</dd>
      <dt class="col-sm-4">Amplificationsuccessdetails</dt>
      <dd class="col-sm-8">{{ $item->amplificationSuccessDetails }}</dd>
      <dt class="col-sm-4">Sampledesignation</dt>
      <dd class="col-sm-8">{{ $item->sampleDesignation }}</dd>
      <dt class="col-sm-4">Idprimerf</dt>
      <dd class="col-sm-8">{{ $item->idPrimerF }}</dd>
      <dt class="col-sm-4">Idprimerr</dt>
      <dd class="col-sm-8">{{ $item->idPrimerR }}</dd>
      <dt class="col-sm-4">Tecnologia secuenciacion</dt>
      <dd class="col-sm-8">{{ $item->tecnologia_secuenciacion }}</dd>
      <dt class="col-sm-4">Consensussequence</dt>
      <dd class="col-sm-8">{{ $item->consensusSequence }}</dd>
      <dt class="col-sm-4">Fechasecuenciacion</dt>
      <dd class="col-sm-8">{{ $item->fechaSecuenciacion }}</dd>
      <dt class="col-sm-4">Sequencingstaff</dt>
      <dd class="col-sm-8">{{ $item->sequencingStaff }}</dd>
      <dt class="col-sm-4">Ordensecuenciacion</dt>
      <dd class="col-sm-8">{{ $item->ordenSecuenciacion }}</dd>
      <dt class="col-sm-4">Geneticaccessionnumber</dt>
      <dd class="col-sm-8">{{ $item->geneticAccessionNumber }}</dd>
      <dt class="col-sm-4">Geneticaccessionuri</dt>
      <dd class="col-sm-8">{{ $item->geneticAccessionURI }}</dd>
    </dl>

    <div style="margin-top:12px;">

      <a class="btn" href="{{ route('tbl-extractions.index') }}">Volver</a>
      <a href="{{ route('tbl-registros-laboratorio.edit', ['idRegistrosLaboratorio' => $item->idRegistrosLaboratorio]) }}"
        class="btn btn-warning">
        Editar
      </a>

    </div>
  </div>
</div>
@endsection
