@extends('layouts.sidebar')
@section('page_title','Editar — Tblregistroslaboratorio')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Tblregistroslaboratorio #{ $item->idRegistrosLaboratorio }</h1>

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

<form method="POST" action="{{ route('tbl-registros-laboratorio.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Idfechapcr</label>
      <input type="text" name="idFechaPCR" value="{{ old('idFechaPCR', isset($item)? $item->idFechaPCR : '') }}" class="input">
    </div>

    <div>
      <label class="label">Idextracciones</label>
      <input type="text" name="idExtracciones" value="{{ old('idExtracciones', isset($item)? $item->idExtracciones : '') }}" class="input">
    </div>

    <div>
      <label class="label">Vol adn pcr</label>
      <input type="number" name="vol_ADN_PCR" value="{{ old('vol_ADN_PCR', isset($item)? $item->vol_ADN_PCR : '') }}" class="input">
    </div>

    <div>
      <label class="label">Amplificationsuccess</label>
      <input type="checkbox" name="amplificationSuccess" value="1" @checked(old('amplificationSuccess', isset($item)? $item->amplificationSuccess : false))>
    </div>

    <div>
      <label class="label">Amplificationsuccessdetails</label>
      <textarea name="amplificationSuccessDetails" class="input" rows="3">{{ old('amplificationSuccessDetails', isset($item)? $item->amplificationSuccessDetails : '') }}</textarea>
    </div>

    <div>
      <label class="label">Sampledesignation</label>
      <input type="text" name="sampleDesignation" value="{{ old('sampleDesignation', isset($item)? $item->sampleDesignation : '') }}" class="input">
    </div>

    <div>
      <label class="label">Idprimerf</label>
      <input type="text" name="idPrimerF" value="{{ old('idPrimerF', isset($item)? $item->idPrimerF : '') }}" class="input">
    </div>

    <div>
      <label class="label">Idprimerr</label>
      <input type="text" name="idPrimerR" value="{{ old('idPrimerR', isset($item)? $item->idPrimerR : '') }}" class="input">
    </div>

    <div>
      <label class="label">Tecnologia secuenciacion</label>
      <input type="text" name="tecnologia_secuenciacion" value="{{ old('tecnologia_secuenciacion', isset($item)? $item->tecnologia_secuenciacion : '') }}" class="input">
    </div>

    <div>
      <label class="label">Consensussequence</label>
      <textarea name="consensusSequence" class="input" rows="3">{{ old('consensusSequence', isset($item)? $item->consensusSequence : '') }}</textarea>
    </div>

    <div>
      <label class="label">Fechasecuenciacion</label>
      <input type="date" name="fechaSecuenciacion" value="{{ old('fechaSecuenciacion', isset($item)? $item->fechaSecuenciacion : '') }}" class="input">
    </div>

    <div>
      <label class="label">Sequencingstaff</label>
      <input type="text" name="sequencingStaff" value="{{ old('sequencingStaff', isset($item)? $item->sequencingStaff : '') }}" class="input">
    </div>

    <div>
      <label class="label">Ordensecuenciacion</label>
      <input type="text" name="ordenSecuenciacion" value="{{ old('ordenSecuenciacion', isset($item)? $item->ordenSecuenciacion : '') }}" class="input">
    </div>

    <div>
      <label class="label">Geneticaccessionnumber</label>
      <input type="text" name="geneticAccessionNumber" value="{{ old('geneticAccessionNumber', isset($item)? $item->geneticAccessionNumber : '') }}" class="input">
    </div>

    <div>
      <label class="label">Geneticaccessionuri</label>
      <textarea name="geneticAccessionURI" class="input" rows="3">{{ old('geneticAccessionURI', isset($item)? $item->geneticAccessionURI : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('tbl-extractions.index',$item) }}" class="btn">Cancelar</a>
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