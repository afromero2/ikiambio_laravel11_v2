@extends('layouts.sidebar')
@section('page_title','Nuevo — tbl-registros-laboratorio')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — tbl-registros-laboratorio</h1>

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
<form method="POST" action="{{ route('tbl-registros-laboratorio.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">
    
    <div>
      <label class="label">Idextracciones</label>
      <input type="text" name="idExtracciones" value="{{ old('idExtracciones', $idExtracciones) }}" class="input" readonly>
    </div>

    <div>
      <label class="label">Idfechapcr</label>
      <input type="text" name="idFechaPCR" value="{{ old('idFechaPCR', isset($item)? $item->idFechaPCR : '') }}" class="input">
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
    <button class="btn primary">Guardar</button>
    <a href="{{ route('tbl-extractions.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
