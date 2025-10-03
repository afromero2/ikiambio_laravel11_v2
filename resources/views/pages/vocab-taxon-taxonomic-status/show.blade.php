@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab taxon taxonomicstatus')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab taxon taxonomicstatus #{ $item->taxonomicStatus_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Taxonomicstatus id</dt>
      <dd class="col-sm-8">{{ $item->taxonomicStatus_id }}</dd>
      <dt class="col-sm-4">Taxonomicstatus value</dt>
      <dd class="col-sm-8">{{ $item->taxonomicStatus_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-taxon-taxonomic-status.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-taxon-taxonomic-status.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
