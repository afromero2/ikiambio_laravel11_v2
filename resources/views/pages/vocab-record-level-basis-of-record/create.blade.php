@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab record level basisofrecord')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab record level basisofrecord</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    {{ __('validation.txtValidacion') }}
  </div>
@endif

<form method="POST" action="{{ route('vocab-record-level-basis-of-record.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Basisofrecord value </label>
      <input type="text" name="basisofrecord_value" value="{{ old('basisofrecord_value', isset($item)? $item->basisofrecord_value : '') }}" class="input">
      @error('basisofrecord_value') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-record-level-basis-of-record.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
