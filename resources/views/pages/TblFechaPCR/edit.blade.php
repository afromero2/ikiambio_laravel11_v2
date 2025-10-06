@extends('layouts.sidebar')
@section('page_title','Editar — Tblfechapcr')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Tblfechapcr #{ $item->idFechaPCR }</h1>

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

<form method="POST" action="{{ route('tbl-fecha-pcr.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Amplificationdate</label>
      <input type="date" name="amplificationDate" value="{{ old('amplificationDate', isset($item)? $item->amplificationDate : '') }}" class="input">
    </div>

    <div>
      <label class="label">Amplificationmethod</label>
      <input type="text" name="amplificationMethod" value="{{ old('amplificationMethod', isset($item)? $item->amplificationMethod : '') }}" class="input">
    </div>

    <div>
      <label class="label">Lugar process</label>
      <input type="text" name="lugar_process" value="{{ old('lugar_process', isset($item)? $item->lugar_process : '') }}" class="input">
    </div>

    <div>
      <label class="label">Amplificationstaff</label>
      <input type="text" name="amplificationStaff" value="{{ old('amplificationStaff', isset($item)? $item->amplificationStaff : '') }}" class="input">
    </div>

    <div>
      <label class="label">Num reacciones</label>
      <input type="number" name="num_reacciones" value="{{ old('num_reacciones', isset($item)? $item->num_reacciones : '') }}" class="input">
    </div>

    <div>
      <label class="label">Volumen finalrx</label>
      <input type="number" name="volumen_finalRx" value="{{ old('volumen_finalRx', isset($item)? $item->volumen_finalRx : '') }}" class="input">
    </div>

    <div>
      <label class="label">Mastermix</label>
      <input type="number" name="masterMix" value="{{ old('masterMix', isset($item)? $item->masterMix : '') }}" class="input">
    </div>

    <div>
      <label class="label">Clh20</label>
      <input type="number" name="clh20" value="{{ old('clh20', isset($item)? $item->clh20 : '') }}" class="input">
    </div>

    <div>
      <label class="label">Buffer</label>
      <input type="number" name="buffer" value="{{ old('buffer', isset($item)? $item->buffer : '') }}" class="input">
    </div>

    <div>
      <label class="label">Bsa</label>
      <input type="number" name="bsa" value="{{ old('bsa', isset($item)? $item->bsa : '') }}" class="input">
    </div>

    <div>
      <label class="label">Mgcl</label>
      <input type="number" name="mgcl" value="{{ old('mgcl', isset($item)? $item->mgcl : '') }}" class="input">
    </div>

    <div>
      <label class="label">Dntp</label>
      <input type="number" name="dntp" value="{{ old('dntp', isset($item)? $item->dntp : '') }}" class="input">
    </div>

    <div>
      <label class="label">Primer f</label>
      <input type="number" name="primer_F" value="{{ old('primer_F', isset($item)? $item->primer_F : '') }}" class="input">
    </div>

    <div>
      <label class="label">Primer r</label>
      <input type="number" name="primer_R" value="{{ old('primer_R', isset($item)? $item->primer_R : '') }}" class="input">
    </div>

    <div>
      <label class="label">Taq</label>
      <input type="number" name="taq" value="{{ old('taq', isset($item)? $item->taq : '') }}" class="input">
    </div>

    <div>
      <label class="label">Adn</label>
      <input type="number" name="adn" value="{{ old('adn', isset($item)? $item->adn : '') }}" class="input">
    </div>

    <div>
      <label class="label">Equipo pcr</label>
      <input type="text" name="equipo_PCR" value="{{ old('equipo_PCR', isset($item)? $item->equipo_PCR : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pre c</label>
      <input type="number" name="pre_c" value="{{ old('pre_c', isset($item)? $item->pre_c : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pretiempo</label>
      <input type="number" name="pretiempo" value="{{ old('pretiempo', isset($item)? $item->pretiempo : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pcr1 c</label>
      <input type="number" name="pcr1_c" value="{{ old('pcr1_c', isset($item)? $item->pcr1_c : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pcr1tiempo</label>
      <input type="number" name="pcr1tiempo" value="{{ old('pcr1tiempo', isset($item)? $item->pcr1tiempo : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pcr2 c</label>
      <input type="number" name="pcr2_c" value="{{ old('pcr2_c', isset($item)? $item->pcr2_c : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pcr2tiempo</label>
      <input type="number" name="pcr2tiempo" value="{{ old('pcr2tiempo', isset($item)? $item->pcr2tiempo : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pcr3 c</label>
      <input type="number" name="pcr3_c" value="{{ old('pcr3_c', isset($item)? $item->pcr3_c : '') }}" class="input">
    </div>

    <div>
      <label class="label">Pcr3tiempo</label>
      <input type="number" name="pcr3tiempo" value="{{ old('pcr3tiempo', isset($item)? $item->pcr3tiempo : '') }}" class="input">
    </div>

    <div>
      <label class="label">Post c</label>
      <input type="number" name="post_c" value="{{ old('post_c', isset($item)? $item->post_c : '') }}" class="input">
    </div>

    <div>
      <label class="label">Post tiempo</label>
      <input type="number" name="post_tiempo" value="{{ old('post_tiempo', isset($item)? $item->post_tiempo : '') }}" class="input">
    </div>

    <div>
      <label class="label">Final c</label>
      <input type="number" name="final_c" value="{{ old('final_c', isset($item)? $item->final_c : '') }}" class="input">
    </div>

    <div>
      <label class="label">Ciclos</label>
      <input type="number" name="ciclos" value="{{ old('ciclos', isset($item)? $item->ciclos : '') }}" class="input">
    </div>

    <div>
      <label class="label">Imagenpcraccessionuri</label>
      <input type="text" name="imagenPCRAccessionURI" value="{{ old('imagenPCRAccessionURI', isset($item)? $item->imagenPCRAccessionURI : '') }}" class="input">
    </div>

    <div>
      <label class="label">Imagenpcr</label>
      <textarea name="imagenPCR" class="input" rows="3">{{ old('imagenPCR', isset($item)? $item->imagenPCR : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('tbl-fecha-pcr.index') }}" class="btn">Cancelar</a>
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
