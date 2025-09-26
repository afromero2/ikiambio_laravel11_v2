@extends('layouts.sidebar')
@section('page_title','Detalle — Tblmultimedia')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Tblmultimedia #{ $item->idMultimedia }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Idmultimedia</dt>
      <dd class="col-sm-8">{{ $item->idMultimedia }}</dd>
      <dt class="col-sm-4">id_occ_bd</dt>
      <dd class="col-sm-8">{{ $item->id_occ_bd }}</dd>
      <dt class="col-sm-4">Type</dt>
      <dd class="col-sm-8">{{ $item->type }}</dd>
      <dt class="col-sm-4">Format</dt>
      <dd class="col-sm-8">{{ $item->format }}</dd>
      <dt class="col-sm-4">Identifier</dt>
      <dd class="col-sm-8">{{ $item->identifier }}</dd>
      <dt class="col-sm-4">Title</dt>
      <dd class="col-sm-8">{{ $item->title }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
      <dt class="col-sm-4">Created</dt>
      <dd class="col-sm-8">{{ $item->created }}</dd>
      <dt class="col-sm-4">Creator</dt>
      <dd class="col-sm-8">{{ $item->creator }}</dd>
      <dt class="col-sm-4">Contributor</dt>
      <dd class="col-sm-8">{{ $item->contributor }}</dd>
      <dt class="col-sm-4">Publisher</dt>
      <dd class="col-sm-8">{{ $item->publisher }}</dd>
      <dt class="col-sm-4">License</dt>
      <dd class="col-sm-8">{{ $item->license }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('tbl-multimedia.edit', $item) }}">Editar</a>
      <a class="btn" href="{{ route('occurrence.index') }}">Volver</a>
    </div>
  </div>
</div>
@endsection
