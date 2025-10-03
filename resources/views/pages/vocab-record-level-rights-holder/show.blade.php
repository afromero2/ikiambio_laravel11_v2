@extends('layouts.sidebar')
@section('page_title','Detalle — Rights holder')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Rights holder #{{ $item->rightsHolder_id }}</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">rightsHolder_id</dt>
      <dd class="col-sm-8">{{ $item->rightsHolder_id }}</dd>

      <dt class="col-sm-4">rightsHolder_value</dt>
      <dd class="col-sm-8">{{ $item->rightsHolder_value }}</dd>

      <dt class="col-sm-4">description</dt>
      <dd class="col-sm-8">{{ $item->description }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('vocab-record-level-rights-holder.index') }}">Volver</a>
      <a class="btn" href="{{ route('vocab-record-level-rights-holder.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
