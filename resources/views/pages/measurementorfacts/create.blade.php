@extends('layouts.sidebar')
@section('page_title','Nuevo — Measurementorfacts')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Measurementorfacts</h1>

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

<form method="POST" action="{{ route('measurement-or-facts.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Id occ bd</label>
      {{-- <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', isset($item)? $item->id_occ_bd : '') }}" class="input"> --}}
      <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', $occurrenceId) }}" class="input" readonly>
    </div>

    <div>
      <label class="label">Measurementtype</label>
      <input type="text" name="measurementType" value="{{ old('measurementType', isset($item)? $item->measurementType : '') }}" class="input">
    </div>

    <div>
      <label class="label">Measurementvalue</label>
      <input type="text" name="measurementValue" value="{{ old('measurementValue', isset($item)? $item->measurementValue : '') }}" class="input">
    </div>

    <div>
      <label class="label">Measurementaccuracy</label>
      <input type="text" name="measurementAccuracy" value="{{ old('measurementAccuracy', isset($item)? $item->measurementAccuracy : '') }}" class="input">
    </div>

    <div>
      <label class="label">Measurementunit</label>
      <input type="text" name="measurementUnit" value="{{ old('measurementUnit', isset($item)? $item->measurementUnit : '') }}" class="input">
    </div>

    <div>
      <label class="label">Measurementdeterminedby</label>
      <input type="text" name="measurementDeterminedBy" value="{{ old('measurementDeterminedBy', isset($item)? $item->measurementDeterminedBy : '') }}" class="input">
    </div>

    <div>
      <label class="label">Measurementdetermineddate</label>
      <input type="date" name="measurementDeterminedDate" value="{{ old('measurementDeterminedDate', isset($item)? $item->measurementDeterminedDate : '') }}" class="input">
    </div>

    <div>
      <label class="label">Measurementmethod</label>
      <textarea name="measurementMethod" class="input" rows="3">{{ old('measurementMethod', isset($item)? $item->measurementMethod : '') }}</textarea>
    </div>

    <div>
      <label class="label">Measurementremarks</label>
      <textarea name="measurementRemarks" class="input" rows="3">{{ old('measurementRemarks', isset($item)? $item->measurementRemarks : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('occurrence.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
