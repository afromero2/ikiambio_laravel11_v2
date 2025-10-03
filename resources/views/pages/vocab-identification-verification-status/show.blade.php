@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab identification verificationstatus')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab identification verificationstatus #{ $item->vocab_identification_verificationStatus_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Vocab identification verificationstatus id</dt>
      <dd class="col-sm-8">{{ $item->vocab_identification_verificationStatus_id }}</dd>
      <dt class="col-sm-4">Identificationverificationstatus value</dt>
      <dd class="col-sm-8">{{ $item->identificationVerificationStatus_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-identification-verification-status.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-identification-verification-status.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
