@php use Illuminate\Support\Str; @endphp

<div class="row g-3">
  {{-- Claves "externas" y campos principales --}}
  <div class="col-md-4">
    <label class="label" for="occurrenceID">OccurrenceID</label>
    <input type="text" name="occurrenceID" id="occurrenceID" class="input"
           value="{{ old('occurrenceID', $item->occurrenceID ?? '') }}"
           placeholder="Ingrese su OccurrenceID">
    @error('occurrenceID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="record_level_id">Record level</label>
    <select name="record_level_id" id="record_level_id" class="input">
      @if($recordLevels->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($recordLevels as $opt)
        <option value="{{ $opt->record_level_id }}"
          @selected(old('record_level_id', $item->record_level_id ?? null) == $opt->record_level_id)>
          #{{ $opt->record_level_id }} @if($opt->datasetName ?? false) — {{ Str::limit($opt->datasetName, 40) }} @endif
        </option>
      @endforeach
    </select>
    @error('record_level_id') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="catalogNumber">Catalog Number 1111</label>
    <input type="text" name="catalogNumber" id="catalogNumber" class="input" class="input @error('catalogNumber') is-invalid @enderror"
           value="{{ old('catalogNumber', $item->catalogNumber ?? '') }}">
    @error('catalogNumber') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="recordNumber">Record Number</label>
    <input type="text" name="recordNumber" id="recordNumber" class="input"
           value="{{ old('recordNumber', $item->recordNumber ?? '') }}">
    @error('recordNumber') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="recordedBy">Recorded By</label>
    <input type="text" name="recordedBy" id="recordedBy" class="input"
           value="{{ old('recordedBy', $item->recordedBy ?? '') }}">
    @error('recordedBy') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="individualCount">Individual Count</label>
    <input type="number" name="individualCount" id="individualCount" class="input"
           value="{{ old('individualCount', $item->individualCount ?? '') }}">
    @error('individualCount') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="organismQuantity">Organism Quantity</label>
    <input type="number" step="any" name="organismQuantity" id="organismQuantity" class="input"
           value="{{ old('organismQuantity', $item->organismQuantity ?? '') }}">
    @error('organismQuantity') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Vocabs obligatorias --}}
  <div class="col-md-4">
    <label class="label" for="organismQuantityType">Organism Quantity Type *</label>
    <select name="organismQuantityType" id="organismQuantityType" class="input">
      @if($oqtypes->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($oqtypes as $opt)
        <option value="{{ $opt->oqtype_id }}"
          @selected(old('organismQuantityType', $item->organismQuantityType ?? null) == $opt->oqtype_id)>
          {{ $opt->oqtype_value }} @if($opt->description) — {{ Str::limit($opt->description, 50) }} @endif
        </option>
      @endforeach
    </select>
    @error('organismQuantityType') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="sex">Sex *</label>
    <select name="sex" id="sex" class="input">
      @if($sexes->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($sexes as $opt)
        <option value="{{ $opt->sex_id }}"
          @selected(old('sex', $item->sex ?? null) == $opt->sex_id)>
          {{ $opt->sex_value }}
        </option>
      @endforeach
    </select>
    @error('sex') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="lifeStage">Life stage *</label>
    <select name="lifeStage" id="lifeStage" class="input">
      @if($lifeStages->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($lifeStages as $opt)
        <option value="{{ $opt->lifestage_id }}"
          @selected(old('lifeStage', $item->lifeStage ?? null) == $opt->lifestage_id)>
          {{ $opt->lifestage_value }}
        </option>
      @endforeach
    </select>
    @error('lifeStage') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="reproductiveCondition">Reproductive condition *</label>
    <select name="reproductiveCondition" id="reproductiveCondition" class="input">
      @if($reproConds->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($reproConds as $opt)
        <option value="{{ $opt->reprocond_id }}"
          @selected(old('reproductiveCondition', $item->reproductiveCondition ?? null) == $opt->reprocond_id)>
          {{ $opt->reprocond_value }}
        </option>
      @endforeach
    </select>
    @error('reproductiveCondition') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="establishmentMeans">Establishment means *</label>
    <select name="establishmentMeans" id="establishmentMeans" class="input">
      @if($estabMeans->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($estabMeans as $opt)
        <option value="{{ $opt->estabmeans_id }}"
          @selected(old('establishmentMeans', $item->establishmentMeans ?? null) == $opt->estabmeans_id)>
          {{ $opt->estabmeans_value }}
        </option>
      @endforeach
    </select>
    @error('establishmentMeans') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="label" for="disposition">Disposition *</label>
    <select name="disposition" id="disposition" class="input">
      @if($dispositions->count() > 1)
        <option value="">— Selecciona —</option>
      @endif
      @foreach($dispositions as $opt)
        <option value="{{ $opt->disposition_id }}"
          @selected(old('disposition', $item->disposition ?? null) == $opt->disposition_id)>
          {{ $opt->disposition_value }}
        </option>
      @endforeach
    </select>
    @error('disposition') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Textos largos --}}
  <div class="col-md-12">
    <label class="label" for="behavior">Behavior</label>
    <textarea name="behavior" id="behavior" rows="2" class="input">{{ old('behavior', $item->behavior ?? '') }}</textarea>
    @error('behavior') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="substrate">Substrate</label>
    <textarea name="substrate" id="substrate" rows="2" class="input">{{ old('substrate', $item->substrate ?? '') }}</textarea>
    @error('substrate') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="preparations">Preparations</label>
    <textarea name="preparations" id="preparations" rows="2" class="input">{{ old('preparations', $item->preparations ?? '') }}</textarea>
    @error('preparations') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- =================== Organism (ID + sub-form opcional) =================== --}}
  <div class="col-md-4">
    <label class="label" for="organismID">Organism ID</label>
    <input list="dl-organisms" name="organismID" id="organismID" class="input"
          value="{{ old('organismID', $item->organismID ?? '') }}"
          placeholder="Escribe para buscar...">
    <datalist id="dl-organisms"></datalist>

    <a id="link-organism"
      href="{{ route('organism.index') }}"
      target="_blank"
      rel="noopener noreferrer"
      class="btn btn-link disabled"
      aria-disabled="true">
      Ver Organism
    </a>

    <a id="org-edit22"
      href="{{ route('organism.edit', $item->organismID) }}"
      target="_blank"
      rel="noopener noreferrer"
      class="btn btn-link"
      aria-disabled="true">
      Edit Organism
    </a>
   

    @push('scripts')
    <script>
    (function () {
      const $input = document.getElementById('organismID');
      const $link  = document.getElementById('link-organism');

      // Plantilla de URL para el show. Luego reemplazamos "__ID__" por el valor real.
      const showTpl = @json(route('organism.show', '__ID__'));
      const indexUrl = @json(route('organism.index'));

      function updateLink() {
        const id = ($input.value || '').trim();
        if (id) {
          $link.href = showTpl.replace('__ID__', encodeURIComponent(id));
          $link.classList.remove('disabled');
          $link.setAttribute('aria-disabled', 'false');
        } else {
          // Sin ID -> apunta al índice y queda deshabilitado visualmente
          $link.href = indexUrl;
          $link.classList.add('disabled');
          $link.setAttribute('aria-disabled', 'true');
        }
      }

      $input.addEventListener('input',  updateLink);
      $input.addEventListener('change', updateLink);
      updateLink(); // estado inicial
    })();
    </script>
    @endpush

    <small class="text-muted">Escribe 2+ caracteres para ver sugerencias o usa el subform para crear.</small>
    @error('organismID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-12">
    <label class="d-inline-flex align-items-center gap-2">
      <input type="checkbox" id="toggle-organism" name="organism_create" value="1"
             {{ old('organism_create') ? 'checked' : '' }}>
      <span>Crear/editar datos de <strong>Organism</strong> en este formulario</span>
    </label>
  </div>

  <div id="organism-subform" class="col-12" style="display:none;">
    <div class="row g-3 mt-1">
      <div class="col-md-12">
        <label class="label" for="organism_associatedOccurrences">Associated Occurrences</label>
        <textarea name="organism_associatedOccurrences" id="organism_associatedOccurrences" rows="2" class="input">{{ old('organism_associatedOccurrences') }}</textarea>
      </div>

      <div class="col-md-12">
        <label class="label" for="organism_associatedOrganisms">Associated Organisms</label>
        <textarea name="organism_associatedOrganisms" id="organism_associatedOrganisms" rows="2" class="input">{{ old('organism_associatedOrganisms') }}</textarea>
      </div>

      <div class="col-md-12">
        <label class="label" for="organism_previousIdentifications">Previous Identifications</label>
        <textarea name="organism_previousIdentifications" id="organism_previousIdentifications" rows="2" class="input">{{ old('organism_previousIdentifications') }}</textarea>
      </div>

      <div class="col-12 mt-2">
        <button type="button" id="btn-save-organism" class="btn btn-secondary">
          Guardar Organism
        </button>
        <small id="organism-save-status" class="ms-2 text-muted"></small>
      </div>
    </div>
    @push('scripts')
      <script>
      (function () {
        // --- ya existente ---
        function setupToggle(chkId, boxId, hasData) {
          const chk = document.getElementById(chkId);
          const box = document.getElementById(boxId);
          if (!chk || !box) return;
          const show = () => { box.style.display = chk.checked ? '' : 'none'; };
          chk.addEventListener('change', show);
          if (chk.checked || hasData) chk.checked = true;
          show();
        }
        const orgHasData =
          !!document.getElementById('organism_associatedOccurrences')?.value ||
          !!document.getElementById('organism_associatedOrganisms')?.value ||
          !!document.getElementById('organism_previousIdentifications')?.value;

        setupToggle('toggle-organism', 'organism-subform', orgHasData);
        setupToggle('toggle-location', 'location-subform', false);
        setupToggle('toggle-taxon', 'taxon-subform', false);
        setupToggle('toggle-identification', 'identification-subform', false);

        // --- NUEVO: guardar Organism vía AJAX ---
        const btn = document.getElementById('btn-save-organism');
        const statusEl = document.getElementById('organism-save-status');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        btn?.addEventListener('click', async () => {
          const payload = {
            organismID: document.getElementById('organismID')?.value?.trim() || null,
            associatedOccurrences: document.getElementById('organism_associatedOccurrences')?.value ?? null,
            associatedOrganisms:   document.getElementById('organism_associatedOrganisms')?.value ?? null,
            previousIdentifications: document.getElementById('organism_previousIdentifications')?.value ?? null,
          };

          statusEl.textContent = 'Guardando...';
          btn.disabled = true;

          try {
            const res = await fetch("{{ route('ajax.organisms.store') }}", {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
              },
              body: JSON.stringify(payload)
            });
            const json = await res.json();

            if (!res.ok || !json.ok) {
              throw json;
            }

            // pintar el ID devuelto en el input principal
            document.getElementById('organismID').value = json.id;
            statusEl.textContent = 'Guardado ✔ (ID: ' + json.id + ')';
            statusEl.classList.remove('text-danger');
            statusEl.classList.add('text-success');
          } catch (err) {
            statusEl.textContent = 'Error al guardar';
            statusEl.classList.remove('text-success');
            statusEl.classList.add('text-danger');
            // Si quieres mostrar errores de validación:
            // console.error(err);
          } finally {
            btn.disabled = false;
          }
        });
      })();
      </script>
    @endpush
  </div>

  {{-- =================== Location (ID + sub-form opcional placeholder) =================== --}}
  <div class="col-md-4">
    <label class="label" for="locationID">Location ID</label>
    <input list="dl-locations" name="locationID" id="locationID" class="input"
          value="{{ old('locationID', $item->locationID ?? '') }}"
          placeholder="Escribe para buscar...">
    <datalist id="dl-locations"></datalist>

    <a id="link-location"
      href="{{ route('location.index') }}"
      target="_blank"
      rel="noopener noreferrer"
      class="btn btn-link disabled"
      aria-disabled="true">
      Ver Location
    </a>

    @push('scripts')
    <script>
    (function () {
      const $input = document.getElementById('locationID');
      const $link  = document.getElementById('link-location');

      // Plantilla de URL para el show. Luego reemplazamos "__ID__" por el valor real.
      const showTpl = @json(route('location.show', '__ID__'));
      const indexUrl = @json(route('location.index'));

      function updateLink() {
        const id = ($input.value || '').trim();
        if (id) {
          $link.href = showTpl.replace('__ID__', encodeURIComponent(id));
          $link.classList.remove('disabled');
          $link.setAttribute('aria-disabled', 'false');
        } else {
          // Sin ID -> apunta al índice y queda deshabilitado visualmente
          $link.href = indexUrl;
          $link.classList.add('disabled');
          $link.setAttribute('aria-disabled', 'true');
        }
      }

      $input.addEventListener('input',  updateLink);
      $input.addEventListener('change', updateLink);
      updateLink(); // estado inicial
    })();
    </script>
    @endpush

    <small class="text-muted">Escribe 2+ caracteres para ver sugerencias o usa el subform para crear.</small>
    @error('locationID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-12">
    <label class="d-inline-flex align-items-center gap-2">
      <input type="checkbox" id="toggle-location" name="location_create" value="1"
             {{ old('location_create') ? 'checked' : '' }}>
      <span>Crear/editar datos de <strong>Location</strong> aquí (por ahora solo el ID)</span>
    </label>
  </div>

  {{-- ====== SUBFORM: LOCATION ====== --}}
  <div id="location-subform" class="col-12" style="display:none">
    <div class="row g-3 mt-1" style="background: #efe7c2; padding:1rem; border-radius:.5rem">

      <div class="col-md-4">
        <label class="label" for="location_id_INEC">ID INEC</label>
        <input type="text" name="location_id_INEC" id="location_id_INEC" class="input"
              value="{{ old('location_id_INEC') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_higherGeographyID">Higher Geography ID</label>
        <input type="text" name="location_higherGeographyID" id="location_higherGeographyID" class="input"
              value="{{ old('location_higherGeographyID') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_continent">Continent *</label>
        <select name="location_continent" id="location_continent" class="input">
          @if($continents->count() > 1)
            <option value="">— Selecciona —</option>
          @endif
          @foreach($continents as $opt) {{-- recibe: continent_id, continent_value --}}
            <option value="{{ $opt->continent_id }}"
              @selected(old('location_continent') == $opt->continent_id)>
              {{ $opt->continent_value }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label class="label" for="location_waterBody">Water body</label>
        <input type="text" name="location_waterBody" id="location_waterBody" class="input"
              value="{{ old('location_waterBody') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_islandGroup">Island group</label>
        <input type="text" name="location_islandGroup" id="location_islandGroup" class="input"
              value="{{ old('location_islandGroup') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_island">Island</label>
        <input type="text" name="location_island" id="location_island" class="input"
              value="{{ old('location_island') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_country">Country</label>
        <input type="text" name="location_country" id="location_country" class="input"
              value="{{ old('location_country') }}">
      </div>

      <div class="col-md-2">
        <label class="label" for="location_countryCode">Country code</label>
        <input type="text" name="location_countryCode" id="location_countryCode" class="input" maxlength="2"
              value="{{ old('location_countryCode') }}">
      </div>

      <div class="col-md-6">
        <label class="label" for="location_stateProvince">State/Province</label>
        <input type="text" name="location_stateProvince" id="location_stateProvince" class="input"
              value="{{ old('location_stateProvince') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_county">County</label>
        <input type="text" name="location_county" id="location_county" class="input"
              value="{{ old('location_county') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_municipality">Municipality</label>
        <input type="text" name="location_municipality" id="location_municipality" class="input"
              value="{{ old('location_municipality') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_locality">Locality</label>
        <input type="text" name="location_locality" id="location_locality" class="input"
              value="{{ old('location_locality') }}">
      </div>

      <div class="col-md-12">
        <label class="label" for="location_verbatimLocality">Verbatim locality</label>
        <textarea name="location_verbatimLocality" id="location_verbatimLocality" rows="2" class="input">{{ old('location_verbatimLocality') }}</textarea>
      </div>

      <div class="col-md-6">
        <label class="label" for="location_verbatimElevation">Verbatim elevation</label>
        <textarea name="location_verbatimElevation" id="location_verbatimElevation" rows="2" class="input">{{ old('location_verbatimElevation') }}</textarea>
      </div>

      <div class="col-md-6">
        <label class="label" for="location_verbatimDepth">Verbatim depth</label>
        <textarea name="location_verbatimDepth" id="location_verbatimDepth" rows="2" class="input">{{ old('location_verbatimDepth') }}</textarea>
      </div>

      <div class="col-md-12">
        <label class="label" for="location_locationRemarks">Location remarks</label>
        <textarea name="location_locationRemarks" id="location_locationRemarks" rows="2" class="input">{{ old('location_locationRemarks') }}</textarea>
      </div>

      <div class="col-md-3">
        <label class="label" for="location_decimalLatitude">Decimal latitude</label>
        <input type="number" step="any" name="location_decimalLatitude" id="location_decimalLatitude" class="input"
              value="{{ old('location_decimalLatitude') }}">
      </div>

      <div class="col-md-3">
        <label class="label" for="location_decimalLongitude">Decimal longitude</label>
        <input type="number" step="any" name="location_decimalLongitude" id="location_decimalLongitude" class="input"
              value="{{ old('location_decimalLongitude') }}">
      </div>

      <div class="col-md-6">
        <label class="label" for="location_geodeticDatum">Geodetic datum</label>
        <input type="text" name="location_geodeticDatum" id="location_geodeticDatum" class="input"
              value="{{ old('location_geodeticDatum') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_verbatimLatitude">Verbatim latitude</label>
        <input type="text" name="location_verbatimLatitude" id="location_verbatimLatitude" class="input"
              value="{{ old('location_verbatimLatitude') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_verbatimLongitude">Verbatim longitude</label>
        <input type="text" name="location_verbatimLongitude" id="location_verbatimLongitude" class="input"
              value="{{ old('location_verbatimLongitude') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_verbatimCoordinateSystem">Verbatim coordinate system</label>
        <input type="text" name="location_verbatimCoordinateSystem" id="location_verbatimCoordinateSystem" class="input"
              value="{{ old('location_verbatimCoordinateSystem') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_verbatimSRS">Verbatim SRS *</label>
        <select name="location_verbatimSRS" id="location_verbatimSRS" class="input">
          @if($verbatimSrs->count() > 1)
            <option value="">— Selecciona —</option>
          @endif
          @foreach($verbatimSrs as $opt) {{-- recibe: verbatimSRS_id, verbatimSRS_value --}}
            <option value="{{ $opt->verbatimSRS_id }}"
              @selected(old('location_verbatimSRS') == $opt->verbatimSRS_id)>
              {{ $opt->verbatimSRS_value }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label class="label" for="location_georeferencedBy">Georeferenced by</label>
        <input type="text" name="location_georeferencedBy" id="location_georeferencedBy" class="input"
              value="{{ old('location_georeferencedBy') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_georeferencedDate">Georeferenced date</label>
        <input type="date" name="location_georeferencedDate" id="location_georeferencedDate" class="input"
              value="{{ old('location_georeferencedDate') }}">
      </div>

      <div class="col-md-4">
        <label class="label" for="location_georeferenceVerificationStatus">Georef. verification status *</label>
        <select name="location_georeferenceVerificationStatus" id="location_georeferenceVerificationStatus" class="input">
          @if($georefStatuses->count() > 1)
            <option value="">— Selecciona —</option>
          @endif
          @foreach($georefStatuses as $opt) {{-- georef_status_id, georef_status_value --}}
            <option value="{{ $opt->georef_status_id }}"
              @selected(old('location_georeferenceVerificationStatus') == $opt->georef_status_id)>
              {{ $opt->georef_status_value }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-8">
        <label class="label" for="location_georeferenceRemarks">Georeference remarks</label>
        <textarea name="location_georeferenceRemarks" id="location_georeferenceRemarks" rows="2" class="input">{{ old('location_georeferenceRemarks') }}</textarea>
      </div>

      {{-- Botón ajax para guardar solo Location --}}
      <div class="col-12 mt-2">
        <button type="button" id="btn-save-location" class="btn btn-secondary">
          Guardar Location
        </button>
        <small id="location-save-status" class="ms-2 text-muted"></small>
      </div>

    </div>

    @push('scripts')
    <script>
    (function () {
      // ... (tu código existente de toggles y Organism)

      const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      const btnLoc    = document.getElementById('btn-save-location');
      const statusLoc = document.getElementById('location-save-status');

      btnLoc?.addEventListener('click', async () => {
        const payload = {
          // usa el ID escrito (o null para que el server lo genere)
          locationID: document.getElementById('locationID')?.value?.trim() || null,

          id_INEC:                      document.getElementById('location_id_INEC')?.value ?? null,
          higherGeographyID:            document.getElementById('location_higherGeographyID')?.value ?? null,
          continent:                    document.getElementById('location_continent')?.value || null,
          waterBody:                    document.getElementById('location_waterBody')?.value ?? null,
          islandGroup:                  document.getElementById('location_islandGroup')?.value ?? null,
          island:                       document.getElementById('location_island')?.value ?? null,
          country:                      document.getElementById('location_country')?.value ?? null,
          countryCode:                  document.getElementById('location_countryCode')?.value ?? null,
          stateProvince:                document.getElementById('location_stateProvince')?.value ?? null,
          county:                       document.getElementById('location_county')?.value ?? null,
          municipality:                 document.getElementById('location_municipality')?.value ?? null,
          locality:                     document.getElementById('location_locality')?.value ?? null,
          verbatimLocality:             document.getElementById('location_verbatimLocality')?.value ?? null,
          verbatimElevation:            document.getElementById('location_verbatimElevation')?.value ?? null,
          verbatimDepth:                document.getElementById('location_verbatimDepth')?.value ?? null,
          locationRemarks:              document.getElementById('location_locationRemarks')?.value ?? null,
          decimalLatitude:              document.getElementById('location_decimalLatitude')?.value ?? null,
          decimalLongitude:             document.getElementById('location_decimalLongitude')?.value ?? null,
          geodeticDatum:                document.getElementById('location_geodeticDatum')?.value ?? null,
          verbatimLatitude:             document.getElementById('location_verbatimLatitude')?.value ?? null,
          verbatimLongitude:            document.getElementById('location_verbatimLongitude')?.value ?? null,
          verbatimCoordinateSystem:     document.getElementById('location_verbatimCoordinateSystem')?.value ?? null,
          verbatimSRS:                  document.getElementById('location_verbatimSRS')?.value || null,
          georeferencedBy:              document.getElementById('location_georeferencedBy')?.value ?? null,
          georeferencedDate:            document.getElementById('location_georeferencedDate')?.value ?? null,
          georeferenceVerificationStatus: document.getElementById('location_georeferenceVerificationStatus')?.value || null,
          georeferenceRemarks:          document.getElementById('location_georeferenceRemarks')?.value ?? null,
        };

        statusLoc.textContent = 'Guardando...';
        btnLoc.disabled = true;

        try {
          const res = await fetch("{{ route('ajax.locations.store') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify(payload)
          });
          const json = await res.json();

          /* if (!res.ok || !json.ok) throw json; */

          if (!res.ok || !json.ok) {
            // Muestra mensaje del server
            statusLoc.textContent = (json && json.message) ? ('Error: ' + json.message) : 'Error al guardar';
            return;
          }


          // Coloca el ID devuelto en el campo principal
          document.getElementById('locationID').value = json.id;
          statusLoc.textContent = 'Guardado ✔ (ID: ' + json.id + ')';
          statusLoc.classList.remove('text-danger');
          statusLoc.classList.add('text-success');
        } catch (e) {

          console.log("error123",e);

          statusLoc.textContent = 'Error al guardar';
          statusLoc.classList.remove('text-success');
          statusLoc.classList.add('text-danger');
        } finally {
          btnLoc.disabled = false;
        }
      });
    })();
    </script>
    @endpush

  </div>

  {{-- =================== Taxon (ID + sub-form opcional placeholder) =================== --}}
  <div class="col-md-4">
    <label class="label" for="taxonID">Taxon ID</label>
    <input type="text" name="taxonID" id="taxonID" class="input
           " value="{{ old('taxonID', $item->taxonID ?? '') }}"
           placeholder="Deja vacío para autogenerar">
    @error('taxonID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-12">
    <label class="d-inline-flex align-items-center gap-2">
      <input type="checkbox" id="toggle-taxon" name="taxon_create" value="1"
             {{ old('taxon_create') ? 'checked' : '' }}>
      <span>Crear/editar datos de <strong>Taxon</strong> aquí (por ahora solo el ID)</span>
    </label>
  </div>

  <div id="taxon-subform" class="col-12" style="display:none;">
    <div class="alert alert-info mt-2">
      Actualmente solo se registrará el <strong>taxonID</strong>. Agrega aquí campos extra cuando los definas.
    </div>
  </div>

  {{-- =================== Identification (ID + sub-form opcional placeholder) =================== --}}
  <div class="col-md-4">
    <label class="label" for="identificationID">Identification ID</label>
    <input type="text" name="identificationID" id="identificationID" class="input"
           value="{{ old('identificationID', $item->identificationID ?? '') }}"
           placeholder="Deja vacío para autogenerar">
    @error('identificationID') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-12">
    <label class="d-inline-flex align-items-center gap-2">
      <input type="checkbox" id="toggle-identification" name="identification_create" value="1"
             {{ old('identification_create') ? 'checked' : '' }}>
      <span>Crear/editar datos de <strong>Identification</strong> aquí (por ahora solo el ID)</span>
    </label>
  </div>

  <div id="identification-subform" class="col-12" style="display:none;">
    <div class="alert alert-info mt-2">
      Actualmente solo se registrará el <strong>identificationID</strong>. Agrega aquí campos extra cuando los definas.
    </div>
  </div>

  {{-- Asociados (texto largos) --}}
  <div class="col-md-12">
    <label class="label" for="associatedMedia">Associated media</label>
    <textarea name="associatedMedia" id="associatedMedia" rows="2" class="input">{{ old('associatedMedia', $item->associatedMedia ?? '') }}</textarea>
    @error('associatedMedia') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="associatedSequences">Associated sequences</label>
    <textarea name="associatedSequences" id="associatedSequences" rows="2" class="input">{{ old('associatedSequences', $item->associatedSequences ?? '') }}</textarea>
    @error('associatedSequences') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="associatedTaxa">Associated taxa</label>
    <textarea name="associatedTaxa" id="associatedTaxa" rows="2" class="input">{{ old('associatedTaxa', $item->associatedTaxa ?? '') }}</textarea>
    @error('associatedTaxa') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="otherCatalogNumbers">Other catalog numbers</label>
    <textarea name="otherCatalogNumbers" id="otherCatalogNumbers" rows="2" class="input">{{ old('otherCatalogNumbers', $item->otherCatalogNumbers ?? '') }}</textarea>
    @error('otherCatalogNumbers') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="label" for="occurrenceRemarks">Occurrence remarks</label>
    <textarea name="occurrenceRemarks" id="occurrenceRemarks" rows="2" class="input">{{ old('occurrenceRemarks', $item->occurrenceRemarks ?? '') }}</textarea>
    @error('occurrenceRemarks') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
</div>

@push('scripts')
<script>
(function () {
  function setupToggle(chkId, boxId, hasData) {
    const chk = document.getElementById(chkId);
    const box = document.getElementById(boxId);
    if (!chk || !box) return;
    const show = () => { box.style.display = chk.checked ? '' : 'none'; };
    chk.addEventListener('change', show);
    if (chk.checked || hasData) chk.checked = true;
    show();
  }

  // Detecta si el sub-form de Organism ya tiene contenido para abrirlo
  const orgHasData =
    !!document.getElementById('organism_associatedOccurrences')?.value ||
    !!document.getElementById('organism_associatedOrganisms')?.value ||
    !!document.getElementById('organism_previousIdentifications')?.value;

  setupToggle('toggle-organism', 'organism-subform', orgHasData);
  setupToggle('toggle-location', 'location-subform', false);
  setupToggle('toggle-taxon', 'taxon-subform', false);
  setupToggle('toggle-identification', 'identification-subform', false);

  // ===== Datalist remoto genérico con debounce =====
  function debounce(fn, ms) {
    let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
  }

  function bindRemoteDatalist(inputId, datalistId, url, {
    onPicked, // callback cuando el usuario selecciona un valor de la lista
    minChars = 2
  } = {}) {
    const $input = document.getElementById(inputId);
    const $dl    = document.getElementById(datalistId);
    if (!$input || !$dl) return;

    const fill = (items) => {
      $dl.innerHTML = '';
      for (const it of items) {
        const opt = document.createElement('option');
        opt.value = it.id;        // lo que se pone en el campo
        opt.label = it.text;      // lo que se muestra como sugerencia
        $dl.appendChild(opt);
      }
    };

    const search = debounce(async (q) => {
      if (!q || q.length < minChars) { $dl.innerHTML = ''; return; }
      try {
        const res  = await fetch(url + '?q=' + encodeURIComponent(q), { headers: { 'Accept':'application/json' } });
        const json = await res.json();
        fill(Array.isArray(json) ? json : []);
      } catch (e) {
        // silencio
      }
    }, 250);

    $input.addEventListener('input', (e) => {
      const v = e.target.value.trim();
      search(v);
    });

    // Al salir del input, si el valor coincide con una opción -> onPicked
    $input.addEventListener('change', () => {
      const v = $input.value.trim();
      if (!v) return;
      const match = Array.from($dl.options).some(o => o.value === v);
      if (match && typeof onPicked === 'function') onPicked(v);
    });
  }

  // Organism: si elige uno existente, desactiva el subform
  bindRemoteDatalist('organismID', 'dl-organisms', "{{ route('ajax.organisms.search') }}", {
    onPicked: () => {
      const chk = document.getElementById('toggle-organism');
      if (chk) { chk.checked = false; chk.dispatchEvent(new Event('change')); }
    }
  });

  // Location: si elige uno existente, desactiva el subform
  bindRemoteDatalist('locationID', 'dl-locations', "{{ route('ajax.locations.search') }}", {
    onPicked: () => {
      const chk = document.getElementById('toggle-location');
      if (chk) { chk.checked = false; chk.dispatchEvent(new Event('change')); }
    }
  });

  
})();
</script>
@endpush
