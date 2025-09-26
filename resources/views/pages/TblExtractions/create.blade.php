@extends('layouts.sidebar')
@section('page_title','Nuevo — Tblextracciones')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Tblextracciones</h1>

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

<form method="POST" action="{{ route('tbl-extractions.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Id occ bd</label>
      {{-- <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', isset($item)? $item->id_occ_bd : '') }}" class="input"> --}}
      <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', $occurrenceId) }}" class="input" readonly>
    </div>

    <div>
      <label class="label">Materialsampletype</label>
      <input type="text" name="materialSampleType" value="{{ old('materialSampleType', isset($item)? $item->materialSampleType : '') }}" class="input">
    </div>

    <div>
      <label class="label">Idregistros</label>
      <input type="text" name="idRegistros" value="{{ old('idRegistros', isset($item)? $item->idRegistros : '') }}" class="input">
    </div>

    <div>
      <label class="label">Fechaextraccion</label>
      <input type="date" name="fechaExtraccion" value="{{ old('fechaExtraccion', isset($item)? $item->fechaExtraccion : '') }}" class="input">
    </div>

    <div>
      <label class="label">Purificationmethod</label>
      <input type="text" name="purificationMethod" value="{{ old('purificationMethod', isset($item)? $item->purificationMethod : '') }}" class="input">
    </div>

    <div>
      <label class="label">Methoddeterminationconcentrationandratios</label>
      <textarea name="methodDeterminationConcentrationAndRatios" class="input" rows="3">{{ old('methodDeterminationConcentrationAndRatios', isset($item)? $item->methodDeterminationConcentrationAndRatios : '') }}</textarea>
    </div>

    <div>
      <label class="label">Adn enstock</label>
      <input type="checkbox" name="adn_enSTOCK" value="1" @checked(old('adn_enSTOCK', isset($item)? $item->adn_enSTOCK : false))>
    </div>

    <div>
      <label class="label">Volume</label>
      <input type="number" name="volume" value="{{ old('volume', isset($item)? $item->volume : '') }}" class="input">
    </div>

    <div>
      <label class="label">Volumeunit</label>
      <input type="text" name="volumeUnit" value="{{ old('volumeUnit', isset($item)? $item->volumeUnit : '') }}" class="input">
    </div>

    <div>
      <label class="label">Concentration</label>
      <input type="number" name="concentration" value="{{ old('concentration', isset($item)? $item->concentration : '') }}" class="input">
    </div>

    <div>
      <label class="label">Concentrationunit</label>
      <input type="text" name="concentrationUnit" value="{{ old('concentrationUnit', isset($item)? $item->concentrationUnit : '') }}" class="input">
    </div>

    <div>
      <label class="label">Ratioofabsorbance260 280</label>
      <input type="number" name="ratioOfAbsorbance260_280" value="{{ old('ratioOfAbsorbance260_280', isset($item)? $item->ratioOfAbsorbance260_280 : '') }}" class="input">
    </div>

    <div>
      <label class="label">Ratioofabsorbance260 230</label>
      <input type="number" name="ratioOfAbsorbance260_230" value="{{ old('ratioOfAbsorbance260_230', isset($item)? $item->ratioOfAbsorbance260_230 : '') }}" class="input">
    </div>

    <div>
      <label class="label">Preservationtype</label>
      <input type="text" name="preservationType" value="{{ old('preservationType', isset($item)? $item->preservationType : '') }}" class="input">
    </div>

    <div>
      <label class="label">Preservationtemperature</label>
      <input type="text" name="preservationTemperature" value="{{ old('preservationTemperature', isset($item)? $item->preservationTemperature : '') }}" class="input">
    </div>

    <div>
      <label class="label">Preservationdatebegin</label>
      <input type="date" name="preservationDateBegin" value="{{ old('preservationDateBegin', isset($item)? $item->preservationDateBegin : '') }}" class="input">
    </div>

    <div>
      <label class="label">Quality</label>
      <input type="text" name="quality" value="{{ old('quality', isset($item)? $item->quality : '') }}" class="input">
    </div>

    <div>
      <label class="label">Qualitycheckdate</label>
      <input type="date" name="qualityCheckDate" value="{{ old('qualityCheckDate', isset($item)? $item->qualityCheckDate : '') }}" class="input">
    </div>

    <div>
      <label class="label">Sieving</label>
      <input type="text" name="sieving" value="{{ old('sieving', isset($item)? $item->sieving : '') }}" class="input">
    </div>

    <div>
      <label class="label">Codigomuestrabiobanco</label>
      <input type="text" name="codigoMuestraBiobanco" value="{{ old('codigoMuestraBiobanco', isset($item)? $item->codigoMuestraBiobanco : '') }}" class="input">
    </div>

    <div>
      <label class="label">Codigoadnbiobanco</label>
      <input type="text" name="codigoADNBiobanco" value="{{ old('codigoADNBiobanco', isset($item)? $item->codigoADNBiobanco : '') }}" class="input">
    </div>

    <div>
      <label class="label">Codigogermoplasmabiobanco</label>
      <input type="text" name="codigoGermoplasmaBiobanco" value="{{ old('codigoGermoplasmaBiobanco', isset($item)? $item->codigoGermoplasmaBiobanco : '') }}" class="input">
    </div>

    <div>
      <label class="label">Extractionstaff</label>
      <input type="text" name="extractionStaff" value="{{ old('extractionStaff', isset($item)? $item->extractionStaff : '') }}" class="input">
    </div>

    <div>
      <label class="label">Qualityremarks</label>
      <textarea name="qualityRemarks" class="input" rows="3">{{ old('qualityRemarks', isset($item)? $item->qualityRemarks : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('occurrence.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
