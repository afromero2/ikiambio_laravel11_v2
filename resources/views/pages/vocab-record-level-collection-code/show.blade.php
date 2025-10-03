@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab record level collectioncode')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab record level collectioncode #{ $item->collectionCode_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Collectioncode id</dt>
      <dd class="col-sm-8">{{ $item->collectionCode_id }}</dd>
      <dt class="col-sm-4">Collectioncode value</dt>
      <dd class="col-sm-8">{{ $item->collectionCode_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-record-level-collection-code.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-record-level-collection-code.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
