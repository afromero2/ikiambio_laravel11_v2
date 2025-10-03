@extends('layouts.sidebar')
@section('page_title','Detalle — Measurementorfacts')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Measurementorfacts #{ $item->measurementID }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Measurementid</dt>
      <dd class="col-sm-8">{{ $item->measurementID }}</dd>
      <dt class="col-sm-4">Id occ bd</dt>
      <dd class="col-sm-8">{{ $item->id_occ_bd }}</dd>
      <dt class="col-sm-4">Measurementtype</dt>
      <dd class="col-sm-8">{{ $item->measurementType }}</dd>
      <dt class="col-sm-4">Measurementvalue</dt>
      <dd class="col-sm-8">{{ $item->measurementValue }}</dd>
      <dt class="col-sm-4">Measurementaccuracy</dt>
      <dd class="col-sm-8">{{ $item->measurementAccuracy }}</dd>
      <dt class="col-sm-4">Measurementunit</dt>
      <dd class="col-sm-8">{{ $item->measurementUnit }}</dd>
      <dt class="col-sm-4">Measurementdeterminedby</dt>
      <dd class="col-sm-8">{{ $item->measurementDeterminedBy }}</dd>
      <dt class="col-sm-4">Measurementdetermineddate</dt>
      <dd class="col-sm-8">{{ $item->measurementDeterminedDate }}</dd>
      <dt class="col-sm-4">Measurementmethod</dt>
      <dd class="col-sm-8">{{ $item->measurementMethod }}</dd>
      <dt class="col-sm-4">Measurementremarks</dt>
      <dd class="col-sm-8">{{ $item->measurementRemarks }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('occurrence.index') }}">Volver</a>
      <a class="btn" href="{{ route('measurement-or-facts.edit', $item) }}">Editar</a>
      {{-- <a class="btn" href="{{ route('measurement-or-facts.index') }}">Volver</a> --}}
    </div>
  </div>
</div>
@endsection
