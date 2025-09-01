@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab location georef status')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab location georef status #{ $item->georef_status_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Georef status id</dt>
      <dd class="col-sm-8">{{ $item->georef_status_id }}</dd>
      <dt class="col-sm-4">Georef status value</dt>
      <dd class="col-sm-8">{{ $item->georef_status_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-location-georef-status.edit', $item) }}">Editar</a>
      <a class="btn" href="{{ route('vocab-location-georef-status.index') }}">Volver</a>
    </div>
  </div>
</div>
@endsection
