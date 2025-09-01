@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab identification typestatus')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab identification typestatus #{ $item->vocab_identification_typeStatus_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Vocab identification typestatus id</dt>
      <dd class="col-sm-8">{{ $item->vocab_identification_typeStatus_id }}</dd>
      <dt class="col-sm-4">Typestatus value</dt>
      <dd class="col-sm-8">{{ $item->typeStatus_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-identification-type-status.edit', $item) }}">Editar</a>
      <a class="btn" href="{{ route('vocab-identification-type-status.index') }}">Volver</a>
    </div>
  </div>
</div>
@endsection
