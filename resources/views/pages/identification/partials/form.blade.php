@php use Illuminate\Support\Str; @endphp

<div class="row g-3">
  {{-- Clave primaria (string) --}}
  <div class="col-md-4">
    <label class="label" for="identificationID">Identification ID</label>
    <input type="text" name="identificationID" id="identificationID" class="input"
           value="{{ old('identificationID', $item->identificationID ?? '') }}"
           placeholder="Deja vacío para generar uno automáticamente (opcional)">
    @error('identificationID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Catálogo: Type Status (FK) --}}
  <div class="col-md-4">
    <label class="label" for="typeStatus">Type status *</label>
    <select name="typeStatus" id="typeStatus" class="input">
      <option value="">— Selecciona —</option>
      @foreach(($idTypeStatuses ?? collect()) as $opt)
        <option value="{{ $opt->vocab_identification_typeStatus_id }}"
          @selected(old('typeStatus', $item->typeStatus ?? null) == $opt->vocab_identification_typeStatus_id)>
          {{ $opt->typeStatus_value }}
        </option>
      @endforeach
    </select>
    @error('typeStatus') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Catálogo: Verification Status (FK) --}}
  <div class="col-md-4">
    <label class="label" for="verificationStatus">Verification status *</label>
    <select name="verificationStatus" id="verificationStatus" class="input">
      <option value="">— Selecciona —</option>
      @foreach(($idVerifStatuses ?? collect()) as $opt)
        <option value="{{ $opt->vocab_identification_verificationStatus_id }}"
          @selected(old('verificationStatus', $item->verificationStatus ?? null) == $opt->vocab_identification_verificationStatus_id)>
          {{ $opt->identificationVerificationStatus_value }}
        </option>
      @endforeach
    </select>
    @error('verificationStatus') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Campos libres recomendados --}}
  <div class="col-md-6">
    <label class="label" for="identifiedBy">Identified by</label>
    <input type="text" name="identifiedBy" id="identifiedBy" class="input"
           value="{{ old('identifiedBy', $item->identifiedBy ?? '') }}">
    @error('identifiedBy') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="label" for="dateIdentified">Date identified</label>
    <input type="date" name="dateIdentified" id="dateIdentified" class="input"
           value="{{ old('dateIdentified', isset($item->dateIdentified) ? \Illuminate\Support\Str::of($item->dateIdentified)->substr(0,10) : '') }}">
    @error('dateIdentified') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-12">
    <label class="label" for="identificationReferences">Identification references</label>
    <textarea name="identificationReferences" id="identificationReferences" rows="2" class="input">{{ old('identificationReferences', $item->identificationReferences ?? '') }}</textarea>
    @error('identificationReferences') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-12">
    <label class="label" for="identificationRemarks">Identification remarks</label>
    <textarea name="identificationRemarks" id="identificationRemarks" rows="2" class="input">{{ old('identificationRemarks', $item->identificationRemarks ?? '') }}</textarea>
    @error('identificationRemarks') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
</div>
