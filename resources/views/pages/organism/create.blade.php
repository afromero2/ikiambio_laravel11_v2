@extends('layouts.sidebar')

@section('title','Organism — Crear')
@section('page_title','Crear Organism')

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

      <form method="POST" action="{{ route('organism.store') }}" class="row g-3">
        @csrf

        @include('pages.organism.partials.form', ['item' => null])

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary">Guardar</button>
          <a href="{{ route('organism.index') }}" class="btn btn-light">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
