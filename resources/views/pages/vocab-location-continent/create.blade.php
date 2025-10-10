@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab location continent')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab location continent</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('vocab-location-continent.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Continent value</label>
      <input type="text" name="continent_value" value="{{ old('continent_value', isset($item)? $item->continent_value : '') }}" class="input">
      @error('continent_value') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-location-continent.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
