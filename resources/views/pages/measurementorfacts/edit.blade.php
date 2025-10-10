@extends('layouts.sidebar')
@section('page_title','Editar — Measurementorfacts')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Measurementorfacts #{ $item->measurementID }</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('measurement-or-facts.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Id occ bd</label>
      <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', isset($item)? $item->id_occ_bd : '') }}" class="input">
      @error('id_occ_bd') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementtype</label>
      <input type="text" name="measurementType" value="{{ old('measurementType', isset($item)? $item->measurementType : '') }}" class="input">
      @error('measurementType') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementvalue</label>
      <input type="text" name="measurementValue" value="{{ old('measurementValue', isset($item)? $item->measurementValue : '') }}" class="input">
      @error('measurementValue') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementaccuracy</label>
      <input type="text" name="measurementAccuracy" value="{{ old('measurementAccuracy', isset($item)? $item->measurementAccuracy : '') }}" class="input">
      @error('measurementAccuracy') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementunit</label>
      <input type="text" name="measurementUnit" value="{{ old('measurementUnit', isset($item)? $item->measurementUnit : '') }}" class="input">
      @error('measurementUnit') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementdeterminedby</label>
      <input type="text" name="measurementDeterminedBy" value="{{ old('measurementDeterminedBy', isset($item)? $item->measurementDeterminedBy : '') }}" class="input">
      @error('measurementDeterminedBy') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementdetermineddate</label>
      <input type="date" name="measurementDeterminedDate" value="{{ old('measurementDeterminedDate', isset($item)? $item->measurementDeterminedDate : '') }}" class="input">
      @error('measurementDeterminedDate') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementmethod</label>
      <textarea name="measurementMethod" class="input" rows="3">{{ old('measurementMethod', isset($item)? $item->measurementMethod : '') }}</textarea>
      @error('measurementMethod') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Measurementremarks</label>
      <textarea name="measurementRemarks" class="input" rows="3">{{ old('measurementRemarks', isset($item)? $item->measurementRemarks : '') }}</textarea>
      @error('measurementRemarks') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('occurrence.index') }}" class="btn">Cancelar</a>
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
