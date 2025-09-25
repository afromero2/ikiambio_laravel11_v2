@php
  use Illuminate\Support\Str;
  $fmtDate = fn($dt) => $dt ? $dt->format('Y-m-d\TH:i') : null;
@endphp

<div class="row g-3">
  {{-- ==================== SELECTS (FKs) ==================== --}}
  <div class="col-md-4">
    <label class="label" for="type">Type *</label>
    <select name="type" id="type" class="input">
      <option value="">— Selecciona —</option>
      @foreach($types as $opt)
        <option value="{{ $opt->type_id }}"
          @selected(old('type', $item->type ?? null) == $opt->type_id)>
          {{ $opt->type_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('type') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="license">License *</label>
    <select name="license" id="license" class="input">
      <option value="">— Selecciona —</option>
      @foreach($licenses as $opt)
        <option value="{{ $opt->license_id }}"
          @selected(old('license', $item->license ?? null) == $opt->license_id)>
          {{ $opt->license_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('license') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="rightsHolder">Rights holder *</label>
    <select name="rightsHolder" id="rightsHolder" class="input">
      <option value="">— Selecciona —</option>
      @foreach($rightsHolders as $opt)
        <option value="{{ $opt->rightsHolder_id }}"
          @selected(old('rightsHolder', $item->rightsHolder ?? null) == $opt->rightsHolder_id)>
          {{ $opt->rightsHolder_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('rightsHolder') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="accessRights">Access rights *</label>
    <select name="accessRights" id="accessRights" class="input">
      <option value="">— Selecciona —</option>
      @foreach($accessRights as $opt)
        <option value="{{ $opt->accessrights_id }}"
          @selected(old('accessRights', $item->accessRights ?? null) == $opt->accessrights_id)>
          {{ $opt->accessrights_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('accessRights') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="institutionID">Institution ID *</label>
    <select name="institutionID" id="institutionID" class="input">
      <option value="">— Selecciona —</option>
      @foreach($institutionIds as $opt)
        <option value="{{ $opt->institution_id }}"
          @selected(old('institutionID', $item->institutionID ?? null) == $opt->institution_id)>
          {{ $opt->institutionID_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('institutionID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="collectionID">Collection ID *</label>
    <select name="collectionID" id="collectionID" class="input">
      <option value="">— Selecciona —</option>
      @foreach($collectionIds as $opt)
        <option value="{{ $opt->collection_id }}"
          @selected(old('collectionID', $item->collectionID ?? null) == $opt->collection_id)>
          {{ $opt->collection_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('collectionID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="institutionCode">Institution code *</label>
    <select name="institutionCode" id="institutionCode" class="input">
      <option value="">— Selecciona —</option>
      @foreach($institutionCodes as $opt)
        <option value="{{ $opt->institutionCode_id }}"
          @selected(old('institutionCode', $item->institutionCode ?? null) == $opt->institutionCode_id)>
          {{ $opt->institutionCode_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('institutionCode') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="collectionCode">Collection code *</label>
    <select name="collectionCode" id="collectionCode" class="input">
      <option value="">— Selecciona —</option>
      @foreach($collectionCodes as $opt)
        <option value="{{ $opt->collectionCode_id }}"
          @selected(old('collectionCode', $item->collectionCode ?? null) == $opt->collectionCode_id)>
          {{ $opt->collectionCode_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('collectionCode') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="ownerInstitutionCode">Owner Institution code *</label>
    <select name="ownerInstitutionCode" id="ownerInstitutionCode" class="input">
      <option value="">— Selecciona —</option>
      @foreach($ownerInstitutionCodes as $opt)
        <option value="{{ $opt->ownerinstitutioncode_id }}"
          @selected(old('ownerInstitutionCode', $item->ownerInstitutionCode ?? null) == $opt->ownerinstitutioncode_id)>
          {{ $opt->ownerinstitutioncode_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('ownerInstitutionCode') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="basisOfRecord">Basis of record *</label>
    <select name="basisOfRecord" id="basisOfRecord" class="input">
      <option value="">— Selecciona —</option>
      @foreach($basisOfRecords as $opt)
        <option value="{{ $opt->basisofrecord_id }}"
          @selected(old('basisOfRecord', $item->basisOfRecord ?? null) == $opt->basisofrecord_id)>
          {{ $opt->basisofrecord_value }} @if($opt->description) — {{ Str::limit($opt->description, 60) }} @endif
        </option>
      @endforeach
    </select>
    @error('basisOfRecord') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- ==================== CAMPOS PROPIOS ==================== --}}
  <div class="col-md-4">
    <label class="label" for="modified">Modified</label>
    <input type="datetime-local" name="modified" id="modified" class="input"
           value="{{ old('modified', isset($item)? $fmtDate($item->modified) : '') }}">
    @error('modified') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-2">
    <label class="label" for="language">Language (2)</label>
    <input type="text" name="language" id="language" class="input" maxlength="2"
           value="{{ old('language', $item->language ?? '') }}">
    @error('language') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="datasetID">Dataset ID</label>
    <input type="text" name="datasetID" id="datasetID" class="input" maxlength="100"
           value="{{ old('datasetID', $item->datasetID ?? '') }}">
    @error('datasetID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="datasetName">Dataset Name</label>
    <input type="text" name="datasetName" id="datasetName" class="input" maxlength="255"
           value="{{ old('datasetName', $item->datasetName ?? '') }}">
    @error('datasetName') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="bibliographicCitation">Bibliographic citation</label>
    <textarea name="bibliographicCitation" id="bibliographicCitation" rows="3" class="input">{{ old('bibliographicCitation', $item->bibliographicCitation ?? '') }}</textarea>
    @error('bibliographicCitation') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="references">References</label>
    <textarea name="references" id="references" rows="3" class="input">{{ old('references', $item->references ?? '') }}</textarea>
    @error('references') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="informationWithheld">Information withheld</label>
    <textarea name="informationWithheld" id="informationWithheld" rows="3" class="input">{{ old('informationWithheld', $item->informationWithheld ?? '') }}</textarea>
    @error('informationWithheld') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="dataGeneralizations">Data generalizations</label>
    <textarea name="dataGeneralizations" id="dataGeneralizations" rows="3" class="input">{{ old('dataGeneralizations', $item->dataGeneralizations ?? '') }}</textarea>
    @error('dataGeneralizations') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
</div>
