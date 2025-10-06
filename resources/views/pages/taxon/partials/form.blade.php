@php
  $item = $item ?? null;
  $taxonRanks = $taxonRanks ?? collect();
  $taxonomicStatuses = $taxonomicStatuses ?? collect();
@endphp

<div class="row g-3">

  <div class="col-md-6">
    <label class="label" for="taxonID">Taxon ID</label>
    <input type="text" name="taxonID" id="taxonID" class="input"
          value="{{ old('taxonID', $item->taxonID ?? '') }}"
          placeholder="Dejar vacío para autogenerar (opcional)">
    @error('taxonID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="scientificNameID">Scientific Name ID</label>
    <input type="text" name="scientificNameID" id="scientificNameID" class="input"
          value="{{ old('scientificNameID', $item->scientificNameID ?? '') }}">
    @error('scientificNameID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="scientificName">Scientific Name *</label>
    <input type="text" name="scientificName" id="scientificName" class="input"
          value="{{ old('scientificName', $item->scientificName ?? '') }}">
    @error('scientificName') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="namePublishedInYear">Name Published In Year</label>
    <input type="number" name="namePublishedInYear" id="namePublishedInYear" class="input"
          value="{{ old('namePublishedInYear', $item->namePublishedInYear ?? '') }}">
    @error('namePublishedInYear') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="namePublishedIn">Name Published In</label>
    <textarea name="namePublishedIn" id="namePublishedIn" rows="2" class="input">{{ old('namePublishedIn', $item->namePublishedIn ?? '') }}</textarea>
    @error('namePublishedIn') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="higherClassification">Higher Classification</label>
    <textarea name="higherClassification" id="higherClassification" rows="2" class="input">{{ old('higherClassification', $item->higherClassification ?? '') }}</textarea>
    @error('higherClassification') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="label" for="kingdom">Kingdom</label>
    <input type="text" name="kingdom" id="kingdom" class="input" value="{{ old('kingdom', $item->kingdom ?? '') }}">
    @error('kingdom') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
  <div class="col-md-3">
    <label class="label" for="phylum">Phylum</label>
    <input type="text" name="phylum" id="phylum" class="input" value="{{ old('phylum', $item->phylum ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="label" for="class">Class</label>
    <input type="text" name="class" id="class" class="input" value="{{ old('class', $item->class ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="label" for="order">Order</label>
    <input type="text" name="order" id="order" class="input" value="{{ old('order', $item->order ?? '') }}">
  </div>

  <div class="col-md-3">
    <label class="label" for="family">Family</label>
    <input type="text" name="family" id="family" class="input" value="{{ old('family', $item->family ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="label" for="genus">Genus</label>
    <input type="text" name="genus" id="genus" class="input" value="{{ old('genus', $item->genus ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="label" for="subgenus">Subgenus</label>
    <input type="text" name="subgenus" id="subgenus" class="input" value="{{ old('subgenus', $item->subgenus ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="label" for="specificEpithet">Specific epithet</label>
    <input type="text" name="specificEpithet" id="specificEpithet" class="input" value="{{ old('specificEpithet', $item->specificEpithet ?? '') }}">
  </div>

  <div class="col-md-3">
    <label class="label" for="intraspecificEpithet">Intraspecific epithet</label>
    <input type="text" name="intraspecificEpithet" id="intraspecificEpithet" class="input" value="{{ old('intraspecificEpithet', $item->intraspecificEpithet ?? '') }}">
  </div>

  <div class="col-md-3">
    <label class="label" for="taxonRank">Taxon Rank</label>
    <select name="taxonRank" id="taxonRank" class="input">
      <option value="">— Selecciona —</option>
      @foreach($taxonRanks as $opt)
        <option value="{{ $opt->taxonRank_id }}"
          @selected(old('taxonRank', $item->taxonRank ?? null) == $opt->taxonRank_id)>
          {{ $opt->taxonRank_value }}
        </option>
      @endforeach
    </select>
    @error('taxonRank') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="label" for="verbatimTaxonRank">Verbatim Taxon Rank</label>
    <input type="text" name="verbatimTaxonRank" id="verbatimTaxonRank" class="input"
          value="{{ old('verbatimTaxonRank', $item->verbatimTaxonRank ?? '') }}">
    @error('verbatimTaxonRank') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="scientificNameAuthorship">Scientific Name Authorship</label>
    <textarea name="scientificNameAuthorship" id="scientificNameAuthorship" rows="2" class="input">{{ old('scientificNameAuthorship', $item->scientificNameAuthorship ?? '') }}</textarea>
    @error('scientificNameAuthorship') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="vernacularName">Vernacular Name</label>
    <textarea name="vernacularName" id="vernacularName" rows="2" class="input">{{ old('vernacularName', $item->vernacularName ?? '') }}</textarea>
    @error('vernacularName') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="label" for="taxonomicStatus">Taxonomic Status</label>
    <select name="taxonomicStatus" id="taxonomicStatus" class="input">
      <option value="">— Selecciona —</option>
      @foreach($taxonomicStatuses as $opt)
        <option value="{{ $opt->taxonomicStatus_id }}"
          @selected(old('taxonomicStatus', $item->taxonomicStatus ?? null) == $opt->taxonomicStatus_id)>
          {{ $opt->taxonomicStatus_value }}
        </option>
      @endforeach
    </select>
    @error('taxonomicStatus') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="taxonRemarks">Taxon Remarks</label>
    <textarea name="taxonRemarks" id="taxonRemarks" rows="3" class="input">{{ old('taxonRemarks', $item->taxonRemarks ?? '') }}</textarea>
    @error('taxonRemarks') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

</div>
