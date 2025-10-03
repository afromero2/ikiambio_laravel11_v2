@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab tblprimers primerdirection')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab tblprimers primerdirection #{ $item->id_primerdirection }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Id primerdirection</dt>
      <dd class="col-sm-8">{{ $item->id_primerdirection }}</dd>
      <dt class="col-sm-4">Primerdirection value</dt>
      <dd class="col-sm-8">{{ $item->primerdirection_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-tblprimers-primer-direction.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-tblprimers-primer-direction.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
