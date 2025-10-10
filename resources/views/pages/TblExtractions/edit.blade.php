@extends('layouts.sidebar')
@section('page_title','Editar — Tblextracciones')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Tblextracciones #{ $item->idExtracciones }</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('tbl-extractions.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Id occ bd</label>
      <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', isset($item)? $item->id_occ_bd : '') }}" class="input">
      @error('id_occ_bd') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Materialsampletype</label>
      <input type="text" name="materialSampleType" value="{{ old('materialSampleType', isset($item)? $item->materialSampleType : '') }}" class="input">
      @error('materialSampleType') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Idregistros</label>
      <input type="text" name="idRegistros" value="{{ old('idRegistros', isset($item)? $item->idRegistros : '') }}" class="input">
      @error('idRegistros') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Fechaextraccion</label>
      <input type="date" name="fechaExtraccion" value="{{ old('fechaExtraccion', isset($item)? $item->fechaExtraccion : '') }}" class="input">
      @error('fechaExtraccion') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Purificationmethod</label>
      <input type="text" name="purificationMethod" value="{{ old('purificationMethod', isset($item)? $item->purificationMethod : '') }}" class="input">
      @error('purificationMethod') <small class="text-danger">{{ $message }}</small> @enderror  
    </div> 

    <div>
      <label class="label">Methoddeterminationconcentrationandratios</label>
      <textarea name="methodDeterminationConcentrationAndRatios" class="input" rows="3">{{ old('methodDeterminationConcentrationAndRatios', isset($item)? $item->methodDeterminationConcentrationAndRatios : '') }}</textarea>
      @error('methodDeterminationConcentrationAndRatios') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Adn enstock</label>
      <input type="checkbox" name="adn_enSTOCK" value="1" @checked(old('adn_enSTOCK', isset($item)? $item->adn_enSTOCK : false))>
    </div>

    <div>
      <label class="label">Volume</label>
      <input type="number" name="volume" value="{{ old('volume', isset($item)? $item->volume : '') }}" class="input"
      min="0" step="0.001" inputmode="decimal" autocomplete="off"
      onkeydown="return !(['e','E','+','-',' '].includes(event.key))"
      onwheel="this.blur()"
      >
      @error('volume') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Volumeunit</label>
      <input type="text" name="volumeUnit" value="{{ old('volumeUnit', isset($item)? $item->volumeUnit : '') }}" class="input">
      @error('volumeUnit') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Concentration</label>
      <input type="number" name="concentration" value="{{ old('concentration', isset($item)? $item->concentration : '') }}" class="input" 
      min="0" step="0.001" inputmode="decimal" autocomplete="off"
      onkeydown="return !(['e','E','+','-',' '].includes(event.key))"
      onwheel="this.blur()"
      >
      @error('concentration') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Concentrationunit</label>
      <input type="text" name="concentrationUnit" value="{{ old('concentrationUnit', isset($item)? $item->concentrationUnit : '') }}" class="input">
      @error('concentrationUnit') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Ratioofabsorbance260 280</label>
      <input type="number" name="ratioOfAbsorbance260_280" value="{{ old('ratioOfAbsorbance260_280', isset($item)? $item->ratioOfAbsorbance260_280 : '') }}" class="input"
      min="0" step="0.001" inputmode="decimal" autocomplete="off"
      onkeydown="return !(['e','E','+','-',' '].includes(event.key))"
      onwheel="this.blur()"
      >
      @error('ratioOfAbsorbance260_280') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Ratioofabsorbance260 230</label>
      <input type="number" name="ratioOfAbsorbance260_230" value="{{ old('ratioOfAbsorbance260_230', isset($item)? $item->ratioOfAbsorbance260_230 : '') }}" class="input"
      min="0" step="0.001" inputmode="decimal" autocomplete="off"
      onkeydown="return !(['e','E','+','-',' '].includes(event.key))"
      onwheel="this.blur()"
      >
      @error('ratioOfAbsorbance260_230') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Preservationtype</label>
      <input type="text" name="preservationType" value="{{ old('preservationType', isset($item)? $item->preservationType : '') }}" class="input">
      @error('preservationType') <small class="text-danger">{{ $message }}</small> @enderror      
    </div>

    <div>
      <label class="label">Preservationtemperature</label>
      <input type="text" name="preservationTemperature" value="{{ old('preservationTemperature', isset($item)? $item->preservationTemperature : '') }}" class="input">
      @error('preservationTemperature') <small class="text-danger">{{ $message }}</small> @enderror      
    </div>

    <div>
      <label class="label">Preservationdatebegin</label>
      <input type="date" name="preservationDateBegin" value="{{ old('preservationDateBegin', isset($item)? $item->preservationDateBegin : '') }}" class="input">
      @error('preservationDateBegin') <small class="text-danger">{{ $message }}</small> @enderror      
    </div>

    <div>
      <label class="label">Quality</label>
      <input type="text" name="quality" value="{{ old('quality', isset($item)? $item->quality : '') }}" class="input">
      @error('quality') <small class="text-danger">{{ $message }}</small> @enderror      
    </div>

    <div>
      <label class="label">Qualitycheckdate</label>
      <input type="date" name="qualityCheckDate" value="{{ old('qualityCheckDate', isset($item)? $item->qualityCheckDate : '') }}" class="input">
      @error('date') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Sieving</label>
      <input type="text" name="sieving" value="{{ old('sieving', isset($item)? $item->sieving : '') }}" class="input">
      @error('sieving') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Codigomuestrabiobanco</label>
      <input type="text" name="codigoMuestraBiobanco" value="{{ old('codigoMuestraBiobanco', isset($item)? $item->codigoMuestraBiobanco : '') }}" class="input">
      @error('codigoMuestraBiobanco') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Codigoadnbiobanco</label>
      <input type="text" name="codigoADNBiobanco" value="{{ old('codigoADNBiobanco', isset($item)? $item->codigoADNBiobanco : '') }}" class="input">
      @error('codigoADNBiobanco') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Codigogermoplasmabiobanco</label>
      <input type="text" name="codigoGermoplasmaBiobanco" value="{{ old('codigoGermoplasmaBiobanco', isset($item)? $item->codigoGermoplasmaBiobanco : '') }}" class="input">
      @error('codigoGermoplasmaBiobanco') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Extractionstaff</label>
      <input type="text" name="extractionStaff" value="{{ old('extractionStaff', isset($item)? $item->extractionStaff : '') }}" class="input">
      @error('extractionStaff') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div>
      <label class="label">Qualityremarks</label>
      <textarea name="qualityRemarks" class="input" rows="3">{{ old('qualityRemarks', isset($item)? $item->qualityRemarks : '') }}</textarea>
      @error('qualityRemarks') <small class="text-danger">{{ $message }}</small> @enderror
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
