@php
  // Evita "undefined variable" si el controller no pasa alguno (mejor pasarlos siempre desde el controller)
  $item = $item ?? null;
  $continents = $continents ?? collect();
  $verbatimSrs = $verbatimSrs ?? collect();
  $georefStatuses = $georefStatuses ?? collect();
@endphp

<div class="row g-3">

  {{-- Clave primaria (opcional; si lo dejas vacío puedes generarla en backend/UUID) --}}
  <div class="col-md-4">
    <label class="label" for="locationID">Location ID</label>
    <input type="text" name="locationID" id="locationID" class="input"
          value="{{ old('locationID', $item->locationID ?? '') }}"
          placeholder="Dejar vacío para autogenerar (opcional)">
    @error('locationID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="id_INEC">ID INEC</label>
    <input type="text" name="id_INEC" id="id_INEC" class="input"
          value="{{ old('id_INEC', $item->id_INEC ?? '') }}">
    @error('id_INEC') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="higherGeographyID">Higher Geography ID</label>
    <input type="text" name="higherGeographyID" id="higherGeographyID" class="input"
          value="{{ old('higherGeographyID', $item->higherGeographyID ?? '') }}">
    @error('higherGeographyID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="continent">Continent *</label>
    <select name="continent" id="continent" class="input">
      @if($continents->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($continents as $opt)
        <option value="{{ $opt->continent_id }}"
          @selected(old('continent', $item->continent ?? null) == $opt->continent_id)>
          {{ $opt->continent_value }}
        </option>
      @endforeach
    </select>
    @error('continent') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="waterBody">Water Body</label>
    <input type="text" name="waterBody" id="waterBody" class="input"
          value="{{ old('waterBody', $item->waterBody ?? '') }}">
    @error('waterBody') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="islandGroup">Island group</label>
    <input type="text" name="islandGroup" id="islandGroup" class="input"
          value="{{ old('islandGroup', $item->islandGroup ?? '') }}">
    @error('islandGroup') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="island">Island</label>
    <input type="text" name="island" id="island" class="input"
          value="{{ old('island', $item->island ?? '') }}">
    @error('island') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="country">Country</label>
    <input type="text" name="country" id="country" class="input"
          value="{{ old('country', $item->country ?? '') }}">
    @error('country') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-2">
    <label class="label" for="countryCode">Country code</label>
    <input type="text" name="countryCode" id="countryCode" maxlength="2" class="input"
          value="{{ old('countryCode', $item->countryCode ?? '') }}">
    @error('countryCode') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="stateProvince">State/Province</label>
    <input type="text" name="stateProvince" id="stateProvince" class="input"
          value="{{ old('stateProvince', $item->stateProvince ?? '') }}">
    @error('stateProvince') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="county">County</label>
    <input type="text" name="county" id="county" class="input"
          value="{{ old('county', $item->county ?? '') }}">
    @error('county') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="municipality">Municipality</label>
    <input type="text" name="municipality" id="municipality" class="input"
          value="{{ old('municipality', $item->municipality ?? '') }}">
    @error('municipality') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="locality">Locality</label>
    <input type="text" name="locality" id="locality" class="input"
          value="{{ old('locality', $item->locality ?? '') }}">
    @error('locality') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="verbatimLocality">Verbatim locality</label>
    <textarea name="verbatimLocality" id="verbatimLocality" rows="2" class="input">{{ old('verbatimLocality', $item->verbatimLocality ?? '') }}</textarea>
    @error('verbatimLocality') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="verbatimElevation">Verbatim elevation</label>
    <textarea name="verbatimElevation" id="verbatimElevation" rows="2" class="input">{{ old('verbatimElevation', $item->verbatimElevation ?? '') }}</textarea>
    @error('verbatimElevation') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="verbatimDepth">Verbatim depth</label>
    <textarea name="verbatimDepth" id="verbatimDepth" rows="2" class="input">{{ old('verbatimDepth', $item->verbatimDepth ?? '') }}</textarea>
    @error('verbatimDepth') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="locationRemarks">Location remarks</label>
    <textarea name="locationRemarks" id="locationRemarks" rows="2" class="input">{{ old('locationRemarks', $item->locationRemarks ?? '') }}</textarea>
    @error('locationRemarks') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="label" for="decimalLatitude">Decimal latitude</label>
    <input type="number" step="any" name="decimalLatitude" id="decimalLatitude" class="input"
          value="{{ old('decimalLatitude', $item->decimalLatitude ?? '') }}">
    @error('decimalLatitude') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="label" for="decimalLongitude">Decimal longitude</label>
    <input type="number" step="any" name="decimalLongitude" id="decimalLongitude" class="input"
          value="{{ old('decimalLongitude', $item->decimalLongitude ?? '') }}">
    @error('decimalLongitude') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="geodeticDatum">Geodetic datum</label>
    <input type="text" name="geodeticDatum" id="geodeticDatum" class="input"
          value="{{ old('geodeticDatum', $item->geodeticDatum ?? '') }}">
    @error('geodeticDatum') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="verbatimLatitude">Verbatim latitude</label>
    <input type="text" name="verbatimLatitude" id="verbatimLatitude" class="input"
          value="{{ old('verbatimLatitude', $item->verbatimLatitude ?? '') }}">
    @error('verbatimLatitude') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="verbatimLongitude">Verbatim longitude</label>
    <input type="text" name="verbatimLongitude" id="verbatimLongitude" class="input"
          value="{{ old('verbatimLongitude', $item->verbatimLongitude ?? '') }}">
    @error('verbatimLongitude') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="verbatimCoordinateSystem">Verbatim coordinate system</label>
    <input type="text" name="verbatimCoordinateSystem" id="verbatimCoordinateSystem" class="input"
          value="{{ old('verbatimCoordinateSystem', $item->verbatimCoordinateSystem ?? '') }}">
    @error('verbatimCoordinateSystem') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="verbatimSRS">Verbatim SRS *</label>
    <select name="verbatimSRS" id="verbatimSRS" class="input">
      @if($verbatimSrs->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($verbatimSrs as $opt)
        <option value="{{ $opt->verbatimSRS_id }}"
          @selected(old('verbatimSRS', $item->verbatimSRS ?? null) == $opt->verbatimSRS_id)>
          {{ $opt->verbatimSRS_value }}
        </option>
      @endforeach
    </select>
    @error('verbatimSRS') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="georeferencedBy">Georeferenced by</label>
    <input type="text" name="georeferencedBy" id="georeferencedBy" class="input"
          value="{{ old('georeferencedBy', $item->georeferencedBy ?? '') }}">
    @error('georeferencedBy') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="georeferencedDate">Georeferenced date</label>
    <input type="date" name="georeferencedDate" id="georeferencedDate" class="input"
          value="{{ old('georeferencedDate', isset($item->georeferencedDate) ? $item->georeferencedDate?->format('Y-m-d') : '') }}">
    @error('georeferencedDate') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="georeferenceVerificationStatus">Georef. verification status *</label>
    <select name="georeferenceVerificationStatus" id="georeferenceVerificationStatus" class="input">
      @if($georefStatuses->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($georefStatuses as $opt)
        <option value="{{ $opt->georef_status_id }}"
          @selected(old('georeferenceVerificationStatus', $item->georeferenceVerificationStatus ?? null) == $opt->georef_status_id)>
          {{ $opt->georef_status_value }}
        </option>
      @endforeach
    </select>
    @error('georeferenceVerificationStatus') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-8">
    <label class="label" for="georeferenceRemarks">Georeference remarks</label>
    <textarea name="georeferenceRemarks" id="georeferenceRemarks" rows="2" class="input">{{ old('georeferenceRemarks', $item->georeferenceRemarks ?? '') }}</textarea>
    @error('georeferenceRemarks') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

</div>
