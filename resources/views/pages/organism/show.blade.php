@extends('layouts.sidebar')

@section('title','Organism — Detalle')
@section('page_title','Detalle Organism')

@section('content')
  <div class="card">
    <div class="card-body">
      <dl class="row">
        <dt class="col-md-3">Organism ID</dt>
        <dd class="col-md-9">{{ $item->organismID }}</dd>

        <dt class="col-md-3">Associated Occurrences</dt>
        <dd class="col-md-9">{{ $item->associatedOccurrences }}</dd>

        <dt class="col-md-3">Associated Organisms</dt>
        <dd class="col-md-9">{{ $item->associatedOrganisms }}</dd>

        <dt class="col-md-3">Previous Identifications</dt>
        <dd class="col-md-9">{{ $item->previousIdentifications }}</dd>
      </dl>

      <div class="d-flex gap-2">
        <a href="{{ route('organism.index') }}" class="btn btn-light">Volver</a>
        <a href="{{ route('organism.edit',$item->organismID) }}" class="btn btn-primary">Editar</a>
      </div>
    </div>
  </div>
@endsection
