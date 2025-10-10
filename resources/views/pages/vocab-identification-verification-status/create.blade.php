@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab identification verificationstatus')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab identification verificationstatus</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif
<form method="POST" action="{{ route('vocab-identification-verification-status.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Identificationverificationstatus value</label>
      <input type="text" name="identificationVerificationStatus_value" value="{{ old('identificationVerificationStatus_value', isset($item)? $item->identificationVerificationStatus_value : '') }}" class="input">
      @error('identificationVerificationStatus_value') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-identification-verification-status.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
