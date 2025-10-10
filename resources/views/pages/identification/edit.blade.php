@extends('layouts.sidebar')
@section('page_title','Editar — Identification')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Identification #{ $item->identificationID }</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('identification.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Identificationqualifier</label>
      <input type="text" name="identificationQualifier" value="{{ old('identificationQualifier', isset($item)? $item->identificationQualifier : '') }}" class="input">
      @error('identificationQualifier') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Typestatus</label>
      <input type="number" name="typeStatus" value="{{ old('typeStatus', isset($item)? $item->typeStatus : '') }}" class="input">
      @error('typeStatus') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Identifiedby</label>
      <input type="text" name="identifiedBy" value="{{ old('identifiedBy', isset($item)? $item->identifiedBy : '') }}" class="input">
      @error('identifiedBy') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Dateidentified</label>
      <input type="date" name="dateIdentified" value="{{ old('dateIdentified', isset($item)? $item->dateIdentified : '') }}" class="input">
      @error('dateIdentified') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Identificationverificationstatus</label>
      <input type="number" name="identificationVerificationStatus" value="{{ old('identificationVerificationStatus', isset($item)? $item->identificationVerificationStatus : '') }}" class="input">
      @error('identificationVerificationStatus') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Identificationremarks</label>
      <textarea name="identificationRemarks" class="input" rows="3">{{ old('identificationRemarks', isset($item)? $item->identificationRemarks : '') }}</textarea>
      @error('identificationRemarks') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('identification.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
  // En edición queremos evitar que borradores del wizard contaminen la vista
  const WIZ_KEYS = [
    'occ_wizard_occurrence_v2',
    'occ_wizard_record_level_v2',
    'occ_wizard_organism_v2',
    'occ_wizard_location_v2',
    'occ_wizard_taxon_v2',
    'occ_wizard_identification_v2',
    'occ_wizard_links_v2',
  ];
  const PREFIX = 'occ_wizard_';

  // 1) Borrar borradores conocidos del wizard
  try { WIZ_KEYS.forEach(k => localStorage.removeItem(k)); } catch {}

  // 2) Parche: mientras estés en esta vista, ignora lecturas/escrituras de esas claves
  (function(ls){
    if (!ls) return;
    const get = ls.getItem.bind(ls);
    const set = ls.setItem.bind(ls);
    const rem = ls.removeItem.bind(ls);

    const isWizardKey = k => typeof k === 'string' && k.startsWith(PREFIX);

    ls.getItem = function(k){ return isWizardKey(k) ? null : get(k); };
    ls.setItem = function(k, v){ if (isWizardKey(k)) return; return set(k, v); };
    // removeItem lo dejamos “normal” por si tu UI necesita limpiar algo explícitamente
    ls.removeItem = function(k){ return rem(k); };
  })(window.localStorage);
})();
</script>
@endpush
