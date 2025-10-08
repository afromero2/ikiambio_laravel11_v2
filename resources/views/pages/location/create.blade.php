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
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

      <form method="POST" action="{{ route('location.store') }}" class="row g-3 btnForms">
        @csrf
        @include('pages.location.partials.form', get_defined_vars())
        <div class="col-12">
        @if(auth()->user()->is_admin)
          <button class="btn btn-primary">Guardar</button>
        @endif
        <a href="{{ route('location.index') }}">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
