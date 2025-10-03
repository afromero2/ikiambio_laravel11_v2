@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab occurrence reproductivecondition')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab occurrence reproductivecondition #{ $item->reprocond_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Reprocond id</dt>
      <dd class="col-sm-8">{{ $item->reprocond_id }}</dd>
      <dt class="col-sm-4">Reprocond value</dt>
      <dd class="col-sm-8">{{ $item->reprocond_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-occurrence-reproductive-condition.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-occurrence-reproductive-condition.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
