@extends('layouts.sidebar')

@section('title','Occurrence — Crear')
@section('page_title','Crear Occurrence')



@section('content')
<div class="card card-body">

  @if (session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

 {{--  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Revisa los siguientes errores:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif --}}

  @if ($errors->any())
    <div class="alert alert-danger">
      {{ __('validation.txtValidacion') }}
    </div>
  @endif

  <form method="POST" action="{{ route('occurrence.store') }}">
    @csrf
    @include('pages.occurrence.partials.form', [
      'item' => $item ?? null,
      'recordLevels' => $recordLevels,
      'oqtypes' => $oqtypes,
      'sexes' => $sexes,
      'lifeStages' => $lifeStages,
      'reproConds' => $reproConds,
      'estabMeans' => $estabMeans,
      'dispositions' => $dispositions,
      'continents' => $continents,
      'verbatimSrs' => $verbatimSrs,
      'georefStatuses' => $georefStatuses,
    ])
    <div class="mt-3">
      <button class="btn btn-primary">Guardar</button>
      <a class="btn btn-outline-secondary" href="{{ route('occurrence.index') }}">Cancelar</a>
    </div>
  </form>
</div>
@endsection
