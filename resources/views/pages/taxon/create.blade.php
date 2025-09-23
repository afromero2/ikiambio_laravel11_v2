@extends('layouts.sidebar')

@section('title','Taxon — Crear')
@section('page_title','Crear Taxon')

@section('content')
  <div class="card">
    <div class="card-body">

      @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('taxon.store') }}" class="row g-3 btnForms">
        @csrf

        @include('pages.taxon.partials.form', [
          'item' => null,
          'taxonRanks' => $taxonRanks,
          'taxonomicStatuses' => $taxonomicStatuses,
        ])

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary">Guardar</button>
          <a href="{{ route('taxon.index') }}" class="btn btn-light">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
