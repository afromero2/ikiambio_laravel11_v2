@extends('layouts.sidebar')
@section('page_title','Detalle — Vocab occurrence disposition')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Vocab occurrence disposition #{ $item->disposition_id }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Disposition id</dt>
      <dd class="col-sm-8">{{ $item->disposition_id }}</dd>
      <dt class="col-sm-4">Disposition value</dt>
      <dd class="col-sm-8">{{ $item->disposition_value }}</dd>
      <dt class="col-sm-4">Description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-occurrence-disposition.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-occurrence-disposition.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
