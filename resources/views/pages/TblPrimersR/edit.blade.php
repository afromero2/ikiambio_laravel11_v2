@extends('layouts.sidebar')
@section('page_title','Editar — Tblprimersr')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Tblprimersr #{ $item->idPrimers }</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('tbl-primers-r.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Genabrev</label>
      <input type="text" name="genAbrev" value="{{ old('genAbrev', isset($item)? $item->genAbrev : '') }}" class="input">
      @error('genAbrev') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Genname</label>
      <input type="text" name="genName" value="{{ old('genName', isset($item)? $item->genName : '') }}" class="input">
      @error('genName') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Primername</label>
      <input type="text" name="primerName" value="{{ old('primerName', isset($item)? $item->primerName : '') }}" class="input">
      @error('primerName') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Primersequence</label>
      <textarea name="primerSequence" class="input" rows="3">{{ old('primerSequence', isset($item)? $item->primerSequence : '') }}</textarea>
      @error('primerSequence') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Primerreferencecitation</label>
      <textarea name="primerReferenceCitation" class="input" rows="3">{{ old('primerReferenceCitation', isset($item)? $item->primerReferenceCitation : '') }}</textarea>
      @error('primerReferenceCitation') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Id primerdirection</label>
      <input type="number" name="id_primerDirection" value="{{ old('id_primerDirection', isset($item)? $item->id_primerDirection : '') }}" class="input">
      @error('id_primerDirection') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Grupo taxonomico</label>
      <input type="text" name="grupo_Taxonomico" value="{{ old('grupo_Taxonomico', isset($item)? $item->grupo_Taxonomico : '') }}" class="input">
      @error('grupo_Taxonomico') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Region</label>
      <input type="text" name="region" value="{{ old('region', isset($item)? $item->region : '') }}" class="input">
      @error('region') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Tecnologia</label>
      <input type="text" name="tecnologia" value="{{ old('tecnologia', isset($item)? $item->tecnologia : '') }}" class="input">
      @error('tecnologia') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Proyecto tesis</label>
      <input type="text" name="proyecto_Tesis" value="{{ old('proyecto_Tesis', isset($item)? $item->proyecto_Tesis : '') }}" class="input">
      @error('proyecto_Tesis') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Longitud primer</label>
      <input type="number" name="longitud_Primer" value="{{ old('longitud_Primer', isset($item)? $item->longitud_Primer : '') }}" class="input">
      @error('longitud_Primer') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Longitud amplicon</label>
      <input type="number" name="Longitud_amplicon" value="{{ old('Longitud_amplicon', isset($item)? $item->Longitud_amplicon : '') }}" class="input">
      @error('Longitud_amplicon') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Gc</label>
      <input type="number" name="gc" value="{{ old('gc', isset($item)? $item->gc : '') }}" class="input">
      @error('gc') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Dnameltingpoint</label>
      <input type="number" name="dnaMeltingPoint" value="{{ old('dnaMeltingPoint', isset($item)? $item->dnaMeltingPoint : '') }}" class="input">
      @error('dnaMeltingPoint') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Annealing temperature</label>
      <input type="number" name="annealing_Temperature" value="{{ old('annealing_Temperature', isset($item)? $item->annealing_Temperature : '') }}" class="input">
      @error('annealing_Temperature') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Primerstaff</label>
      <input type="text" name="primerStaff" value="{{ old('primerStaff', isset($item)? $item->primerStaff : '') }}" class="input">
      @error('primerStaff') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Fecha orden</label>
      <input type="date" name="fecha_orden" value="{{ old('fecha_orden', isset($item)? $item->fecha_orden : '') }}" class="input">
      @error('fecha_orden') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Proveedor</label>
      <input type="text" name="proveedor" value="{{ old('proveedor', isset($item)? $item->proveedor : '') }}" class="input">
      @error('proveedor') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('tbl-primers-r.index') }}" class="btn">Cancelar</a>
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