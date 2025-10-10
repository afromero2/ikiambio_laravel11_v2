@extends('layouts.sidebar')
@section('page_title','Nuevo — Rights holder')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Rights holder</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('vocab-record-level-rights-holder.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">
    <div>
      <label class="label">RightsHolder value</label>
      <input type="text" name="rightsHolder_value" value="{{ old('rightsHolder_value') }}" class="input">
      @error('rightsHolder_value') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">description</label>
      <textarea name="description" class="input" rows="3">{{ old('description') }}</textarea>
      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-record-level-rights-holder.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
