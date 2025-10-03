@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab record level collectionid')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab record level collectionid #{ $item->collection_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Collection id</dt>
      <dd class="col-sm-8">{{ $item->collection_id }}</dd>
      <dt class="col-sm-4">Collection value</dt>
      <dd class="col-sm-8">{{ $item->collection_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-record-level-collection-id.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-record-level-collection-id.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
