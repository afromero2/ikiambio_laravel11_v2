@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab occurrence establishmentmeans')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab occurrence establishmentmeans #{ $item->estabmeans_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Estabmeans id</dt>
      <dd class="col-sm-8">{{ $item->estabmeans_id }}</dd>
      <dt class="col-sm-4">Estabmeans value</dt>
      <dd class="col-sm-8">{{ $item->estabmeans_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-occurrence-establishment-means.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-occurrence-establishment-means.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
