@extends('layouts.sidebar')

@section('title','Location — Crear')
@section('page_title','Crear Location')

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

      <form method="POST" action="{{ route('location.store') }}" class="row g-3">
        @csrf
        @include('pages.location.partials.form', get_defined_vars())
        @if(auth()->user()->is_admin)
          <div class="col-12"><button class="btn btn-primary">Guardar</button></div>
        @endif
      </form>
    </div>
  </div>
@endsection
