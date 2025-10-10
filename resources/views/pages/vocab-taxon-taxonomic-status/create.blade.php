@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab taxon taxonomicstatus')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab taxon taxonomicstatus</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('vocab-taxon-taxonomic-status.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Taxonomicstatus value</label>
      <input type="text" name="taxonomicStatus_value" value="{{ old('taxonomicStatus_value', isset($item)? $item->taxonomicStatus_value : '') }}" class="input">
      @error('taxonomicStatus_value') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-taxon-taxonomic-status.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
