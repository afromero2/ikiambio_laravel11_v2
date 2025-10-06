@php
  $p = $idPrefix ?? ''; // prefijo opcional de IDs
@endphp

<div class="row g-3">
  <div class="col-md-4">
    <label class="label" for="{{ $p }}identificationID">Identification ID (vacío = auto)</label>
    <input type="text" name="identificationID" id="{{ $p }}identificationID" class="form-control"
           value="{{ old('identificationID', $item->identificationID ?? '') }}">
  </div>

  <div class="col-md-4">
    <label class="label" for="{{ $p }}identifiedBy">Identified by</label>
    <input type="text" name="identifiedBy" id="{{ $p }}identifiedBy" class="form-control"
           value="{{ old('identifiedBy', $item->identifiedBy ?? '') }}">
  </div>

  <div class="col-md-4">
    <label class="label" for="{{ $p }}dateIdentified">Date identified</label>
    <input type="date" name="dateIdentified" id="{{ $p }}dateIdentified" class="form-control"
           value="{{ old('dateIdentified', $item->dateIdentified ?? '') }}">
  </div>

  <div class="col-md-4">
    <label class="label" for="{{ $p }}identificationQualifier">Identification qualifier</label>
    <input type="text" name="identificationQualifier" id="{{ $p }}identificationQualifier" class="form-control"
           value="{{ old('identificationQualifier', $item->identificationQualifier ?? '') }}">
  </div>

  <div class="col-md-4">
    <label class="label" for="{{ $p }}typeStatus">Type status333</label>
    <select name="typeStatus" id="{{ $p }}typeStatus" class="form-control">
      <option value="">— Selecciona —</option>
      @foreach($typeStatuses as $opt) {{-- vocab_identification_typeStatus_id, typeStatus_value --}}
        <option value="{{ $opt->vocab_identification_typeStatus_id }}"
          @selected(old('typeStatus', $item->typeStatus ?? null) == $opt->vocab_identification_typeStatus_id)>
          {{ $opt->typeStatus_value }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-4">
    <label class="label" for="{{ $p }}identificationVerificationStatus">Verification status</label>
    <select name="identificationVerificationStatus" id="{{ $p }}identificationVerificationStatus" class="form-control">
      <option value="">— Selecciona —</option>
      @foreach($verificationStatuses as $opt) {{-- vocab_identification_verificationStatus_id, identificationVerificationStatus_value --}}
        <option value="{{ $opt->vocab_identification_verificationStatus_id }}"
          @selected(old('identificationVerificationStatus', $item->identificationVerificationStatus ?? null) == $opt->vocab_identification_verificationStatus_id)>
          {{ $opt->identificationVerificationStatus_value }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12">
    <label class="label" for="{{ $p }}identificationRemarks">Remarks</label>
    <textarea name="identificationRemarks" id="{{ $p }}identificationRemarks" rows="2" class="form-control">{{ old('identificationRemarks', $item->identificationRemarks ?? '') }}</textarea>
  </div>
</div>
