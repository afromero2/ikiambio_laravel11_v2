@extends('layouts.sidebar')
@section('page_title','Detalle — Identification')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Identification #{ $item->identificationID }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Identificationid</dt>
      <dd class="col-sm-8">{{ $item->identificationID }}</dd>
      <dt class="col-sm-4">Identificationqualifier</dt>
      <dd class="col-sm-8">{{ $item->identificationQualifier }}</dd>
      <dt class="col-sm-4">Typestatus</dt>
      <dd class="col-sm-8">{{ $item->typeStatus }}</dd>
      <dt class="col-sm-4">Identifiedby</dt>
      <dd class="col-sm-8">{{ $item->identifiedBy }}</dd>
      <dt class="col-sm-4">Dateidentified</dt>
      <dd class="col-sm-8">{{ $item->dateIdentified }}</dd>
      <dt class="col-sm-4">Identificationverificationstatus</dt>
      <dd class="col-sm-8">{{ $item->identificationVerificationStatus }}</dd>
      <dt class="col-sm-4">Identificationremarks</dt>
      <dd class="col-sm-8">{{ $item->identificationRemarks }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('identification.index') }}">Volver</a>
      <a class="btn" href="{{ route('identification.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
