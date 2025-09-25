{{-- resources/views/pages/occurrence/create_wizard.blade.php --}}

@extends('layouts.sidebar')

@section('title','Crear Occurrence — Wizard')

@section('content')
<div class="container-xxl">
  <h3 class="mb-3">Nueva Ocurrencia</h3>

  @push('scripts')
    <script>
    (function () {
      // Clave de localStorage donde guardamos los vínculos
      const KEY = 'occ_wizard_links_v2';

      // Mapa: cada entidad con ids de hidden/label/summary y key en LS
      const MAP = {
        rl:  { hid:'record_level_id',   lab:'record_level_label',   sum:'summary-rl',  key:'record_level' },
        org: { hid:'organismID',        lab:'organism_label',       sum:'summary-org', key:'organism' },
        loc: { hid:'locationID',        lab:'location_label',       sum:'summary-loc', key:'location' },
        tax: { hid:'taxonID',           lab:'taxon_label',          sum:'summary-tax', key:'taxon' },
        idn: { hid:'identificationID',  lab:'identification_label', sum:'summary-id',  key:'identification' },
      };

      // Escribe hidden + label + summary y persiste en LS
      function setPair(kind, id, label) {
        const cfg = MAP[kind]; if (!cfg) return;
        const $hid = document.getElementById(cfg.hid);
        const $lab = document.getElementById(cfg.lab);
        const $sum = document.getElementById(cfg.sum);

        const text = label || (id ? '#'+id : '');

        if ($hid) $hid.value = id || '';
        if ($lab) $lab.value = text;
        if ($sum) $sum.textContent = text || '—';

        try {
          const links = JSON.parse(localStorage.getItem(KEY) || '{}');
          if (id) { links[cfg.key] = { id, label: text }; }
          else { delete links[cfg.key]; }
          localStorage.setItem(KEY, JSON.stringify(links));
        } catch (e) {
          console.warn('No se pudo guardar en localStorage', e);
        }
      }

      // Restaura hidden + label + summary al cargar la página
      function restoreAll() {
        let links = {};
        try { links = JSON.parse(localStorage.getItem(KEY) || '{}'); } catch {}

        Object.values(MAP).forEach(cfg => {
          const $hid = document.getElementById(cfg.hid);
          const $lab = document.getElementById(cfg.lab);
          const $sum = document.getElementById(cfg.sum);

          // 1) Prioriza valor existente en hidden (old/modelo)
          let id = ($hid?.value || '').trim();
          let label = ($lab?.value || '').trim();

          // 2) Si no hay, toma de localStorage
          if (!id && links[cfg.key]?.id) {
            id    = links[cfg.key].id;
            label = links[cfg.key].label || ('#'+id);
          }

          if ($hid) $hid.value = id;
          if ($lab) $lab.value = label || (id ? '#'+id : '');
          if ($sum) $sum.textContent = label || (id ? '#'+id : '—');
        });
      }

      // EXPONE funciones globales para que tus modales las llamen al seleccionar/guardar
      window.applyRecordLevel     = (id, label) => setPair('rl',  id, label);
      window.applyOrganism        = (id, label) => setPair('org', id, label);
      window.applyLocation        = (id, label) => setPair('loc', id, label);
      window.applyTaxon           = (id, label) => setPair('tax', id, label);
      window.applyIdentification  = (id, label) => setPair('idn', id, label);

      // Restaura al cargar
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', restoreAll);
      } else {
        restoreAll();
      }

      // Debug opcional en consola
      window._occDebugDump = function () {
        const dump = {};
        Object.values(MAP).forEach(cfg => {
          dump[cfg.hid] = document.getElementById(cfg.hid)?.value || '';
          dump[cfg.lab] = document.getElementById(cfg.lab)?.value || '';
        });
        console.log('Hiddens/Labels:', dump);
        console.log('localStorage:', localStorage.getItem(KEY));
      };
    })();
    </script>
    @endpush


  <div class="tab-content border-start border-end border-bottom p-3">
    {{-- ============ TAB 1: OCCURRENCE (SOLO CAMPOS PROPIOS) ============ --}}
    <div class="tab-pane fade show active" id="tab-occurrence" role="tabpanel">
      
      @php $isEdit = isset($item) && $item->exists; @endphp
      
      <script>
        // 1) Flag global
        window.IS_EDIT = {{ $isEdit ? 'true' : 'false' }};

        // 2) Claves usadas por tu autosave (ajústalas si cambiaste nombres)
        window.OCC_WIZ_KEYS = [
          'occ_wizard_occurrence_v2',
          'occ_wizard_record_level_v2',
          'occ_wizard_organism_v2',
          'occ_wizard_location_v2',
          'occ_wizard_taxon_v2',
          'occ_wizard_identification_v2',
          'occ_wizard_links_v2',
        ];

        if (window.IS_EDIT) {
          // Limpia una vez
          try { window.OCC_WIZ_KEYS.forEach(k => localStorage.removeItem(k)); } catch {}

          // 3) Impide que el código del wizard vuelva a leer/escribir esas claves
          (function(ls){
            if (!ls) return;
            const origGet = ls.getItem.bind(ls);
            const origSet = ls.setItem.bind(ls);
            const origRem = ls.removeItem.bind(ls);

            const isWizardKey = k => typeof k === 'string' && /^occ_wizard_/.test(k);

            ls.getItem = function(k){ return isWizardKey(k) ? null : origGet(k); };
            ls.setItem = function(k,v){ if (isWizardKey(k)) return; return origSet(k,v); };
            // removeItem lo dejamos normal por si tu UI llama a "limpiar"
            ls.removeItem = function(k){ return origRem(k); };
          })(window.localStorage);
        }
      </script>

      @if($isEdit)
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          // Ajusta estos helpers a tus IDs reales de inputs/labels
          function setPair(hiddenId, labelId, value, labelText = null) {
            const h = document.getElementById(hiddenId);
            const l = document.getElementById(labelId);
            if (h && value != null && value !== '') h.value = value;
            if (l && (labelText ?? value)) l.value = (labelText ?? value);
          }

          // Record level
          setPair('record_level_id', 'record_level_label',
            @json($item->record_level_id),
            @json('#'.($item->record_level_id ?? '').($item->recordLevel?->datasetName ? ' — '.$item->recordLevel->datasetName : ''))
          );

          // Organism / Location / Taxon / Identification (sólo el ID)
          setPair('organismID', 'organism_label', @json($item->organismID));
          setPair('locationID', 'location_label', @json($item->locationID));
          setPair('taxonID', 'taxon_label', @json($item->taxonID));
          setPair('identificationID', 'identification_label', @json($item->identificationID));

          // Si muestras resúmenes:
          const sum = (id, txt) => { const el = document.getElementById(id); if (el && txt) el.textContent = txt; };
          sum('summary-rl', document.getElementById('record_level_label')?.value || '—');
          sum('summary-org', document.getElementById('organism_label')?.value || '—');
          sum('summary-loc', document.getElementById('location_label')?.value || '—');
          sum('summary-tax', document.getElementById('taxon_label')?.value || '—');
          sum('summary-id',  document.getElementById('identification_label')?.value || '—');
        });
      </script>
      @endif

      {{-- <form id="occ-form" method="POST" action="{{ route('occurrence.store') }}"> --}}
      <form id="occ-form" method="POST" action="{{ $isEdit ? route('occurrence.update',$item) : route('occurrence.store') }}">
        @csrf

        {{-- Si es edición, usar método PATCH --}}
        @if($isEdit) @method('PATCH') @endif


        {{-- Resumen de selección actual --}}
        <div class="alert alert-secondary small" role="alert">
          <div class="mb-1 fw-bold">Selecciones vinculadas:</div>
          <div>Record level: <span id="summary-rl">—</span></div>
          <div>Organism: <span id="summary-org">—</span></div>
          <div>Location: <span id="summary-loc">—</span></div>
          <div>Taxon: <span id="summary-tax">—</span></div>
          <div>Identification: <span id="summary-id">—</span></div>
        </div>

        {{--  RECORD LEVEL Hidden real + campo de solo lectura + botón modal --}}

         <input type="hidden" name="record_level_id" id="record_level_id"
              value="{{ old('record_level_id', $item->record_level_id ?? '') }}">

        <label class="label" for="record_level_label">Record level</label>
        <div class="input-group align-items-center">
         <input type="text" id="record_level_label"
              class="form-control @error('record_level_id') is-invalid @enderror"
              placeholder="Selecciona o crea un Record level"
              value="{{ old('record_level_id')
                          ? ('#'.old('record_level_id'))
                          : (isset($item->record_level_id)
                              ? ('#'.$item->record_level_id.($item->recordLevel?->datasetName ? ' — '.$item->recordLevel->datasetName : ''))
                              : '') }}"
              readonly>
            @error('record_level_id')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

         <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-record-level">
            Elegir / Crear
          </button>&nbsp;
         <div id="rl-actions" class="mt-1" style="display:none">
            <a id="rl-view"  class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="rl-edit"  class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>
        </div>

        <small id="summary-org" class="text-muted d-block mt-1">—</small>


        {{-- ORGANISM: hidden real + label lectura + botón modal + acciones --}}
        <input type="hidden" name="organismID" id="organismID"
              value="{{ old('organismID', $item->organismID ?? '') }}">

        <label class="label d-block">Organism</label>
        <div class="input-group align-items-center">
          <input type="text" id="organism_label"
            class="form-control @error('organismID') is-invalid @enderror"
            placeholder="Selecciona o crea un Organism"
            value="{{ old('organismID', $item->organismID ?? '') ? (old('organismID', $item->organismID ?? '')) : '' }}"
            readonly>
            @error('organismID')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-organism">
            Elegir / Crear
          </button>&nbsp;
          <div id="org-actions" class="mt-1" style="display:none">
            <a id="org-view" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="org-edit" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>
        </div>

        <small id="summary-org" class="text-muted d-block mt-1">—</small>


        {{-- LOCATION: hidden real + label lectura + botón modal + acciones --}}
        <input type="hidden" name="locationID" id="locationID"
              value="{{ old('locationID', $item->locationID ?? '') }}">

        <label class="label d-block">Location</label>
        <div class="input-group align-items-center">
          <input type="text" id="location_label"
            class="form-control @error('locationID') is-invalid @enderror"
            placeholder="Selecciona o crea un Location"
            value="{{ old('locationID', $item->locationID ?? '') ? (old('locationID', $item->locationID ?? '')) : '' }}"
            readonly>
          @error('locationID')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror  

          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-location">
            Elegir / Crear
          </button>&nbsp;
          <div id="loc-actions" class="mt-1" style="display:none">
            <a id="loc-view" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="loc-edit" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>

        </div>

        <small id="summary-loc" class="text-muted d-block mt-1">—</small>


        {{-- TAXON: hidden + label + botón modal + acciones --}}
        <input type="hidden" name="taxonID" id="taxonID"
              value="{{ old('taxonID', $item->taxonID ?? '') }}">

        <label class="label d-block">Taxon</label>
        <div class="input-group align-items-center">
          <input type="text" id="taxon_label"
            class="form-control @error('taxonID') is-invalid @enderror"
            placeholder="Selecciona o crea un Taxon"
            value="{{ old('taxonID', $item->taxonID ?? '') ? (old('taxonID', $item->taxonID ?? '')) : '' }}"
            readonly>
          @error('taxonID')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror

          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-taxon">
            Elegir / Crear
          </button>&nbsp;
          <div id="tax-actions" class="mt-1" style="display:none">
            <a id="tax-view" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="tax-edit" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>

        </div>

        <small id="summary-tax" class="text-muted d-block mt-1">—</small>


        {{-- IDENTIFICATION: hidden + label + botón modal + acciones --}}
        <input type="hidden" name="identificationID" id="identificationID"
              value="{{ old('identificationID', $item->identificationID ?? '') }}">

        <label class="label d-block">Identification</label>
        <div class="input-group align-items-center">
          <input type="text" id="identification_label"
            class="form-control @error('identificationID') is-invalid @enderror"
            placeholder="Selecciona o crea un Identification"
            value="{{ old('identificationID', $item->identificationID ?? '') ? (old('identificationID', $item->identificationID ?? '')) : '' }}"
            readonly>
          @error('identificationID')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror

          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-identification">
            Elegir / Crear
          </button>&nbsp;
            <div id="idn-actions" class="mt-1" style="display:none">
              <a id="idn-view" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
              <a id="idn-edit" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
            </div>
        </div>

        <small id="summary-id" class="text-muted d-block mt-1">—</small>



        {{-- ===== Campos propios de OCCURRENCE ===== --}}
        <div class="row g-3">
          <div class="col-md-4">
            <label class="label" for="occurrenceID">OccurrenceID</label>
            <input type="text" name="occurrenceID" id="occurrenceID" class="input"
                    value="{{ old('occurrenceID', $item->occurrenceID ?? '') }}"
                   placeholder="Ingrese su OccurrenceID">
            @error('occurrenceID') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="catalogNumber">Catalog Number</label>
            <input type="text" name="catalogNumber"
                   id="catalogNumber" class="input"
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

          {{-- Vocabs obligatorias de Occurrence --}}
          <div class="col-md-4">
            <label class="label" for="organismQuantityType">Organism Quantity Type *</label>
            <select name="organismQuantityType" id="organismQuantityType" class="input">
              <option value=""
                @selected(old('organismQuantityType', $item->organismQuantityType ?? null) === null)>
                — Selecciona —
              </option>

              @foreach($oqtypes as $opt)
                <option value="{{ $opt->oqtype_id }}"
                  @selected((int) old('organismQuantityType', $item->organismQuantityType ?? 0) === (int) $opt->oqtype_id)>
                  {{ $opt->oqtype_value }}
                </option>
              @endforeach
            </select>
            @error('organismQuantityType') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="sex">Sex *</label>
            <select name="sex" id="sex" class="input">
              <option value="">— Selecciona —</option>
              @foreach($sexes as $opt)
                <option value="{{ $opt->sex_id }}"
                  @selected((int) old('sex', $item->sex ?? 0) === (int) $opt->sex_id)>
                  {{ $opt->sex_value }}
                </option>
              @endforeach
            </select>
            @error('sex') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="lifeStage">Life stage *</label>
            <select name="lifeStage" id="lifeStage" class="input">
              <option value="">— Selecciona —</option>
              @foreach($lifeStages as $opt)
                <option value="{{ $opt->lifestage_id }}"
                  @selected((int) old('lifeStage', $item->lifeStage ?? 0) === (int) $opt->lifestage_id)>
                  {{ $opt->lifestage_value }}
                </option>
              @endforeach
            </select>
            @error('lifeStage') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="reproductiveCondition">Reproductive condition *</label>
            <select name="reproductiveCondition" id="reproductiveCondition" class="input">
              <option value="">— Selecciona —</option>
              @foreach($reproConds as $opt)
                <option value="{{ $opt->reprocond_id }}"
                  @selected((int) old('reproductiveCondition', $item->reproductiveCondition ?? 0) === (int) $opt->reprocond_id)>
                  {{ $opt->reprocond_value }}
                </option>
              @endforeach
            </select>
            @error('reproductiveCondition') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="establishmentMeans">Establishment means *</label>
            <select name="establishmentMeans" id="establishmentMeans" class="input">
              <option value="">— Selecciona —</option>
              @foreach($estabMeans as $opt)
                <option value="{{ $opt->estabmeans_id }}"
                  @selected((int) old('establishmentMeans', $item->establishmentMeans ?? 0) === (int) $opt->estabmeans_id)>
                  {{ $opt->estabmeans_value }}
                </option>
              @endforeach
            </select>
            @error('establishmentMeans') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="disposition">Disposition *</label>
            <select name="disposition" id="disposition" class="input">
              <option value="">— Selecciona —</option>
              @foreach($dispositions as $opt)
                <option value="{{ $opt->disposition_id }}"
                  @selected((int) old('disposition', $item->disposition ?? 0) === (int) $opt->disposition_id)>
                  {{ $opt->disposition_value }}
                </option>
              @endforeach
            </select>
            @error('disposition') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Textos largos --}}
          <div class="col-md-4">
            <label class="label" for="behavior">Behavior</label>
            <textarea name="behavior" id="behavior" rows="2" class="input">{{ old('behavior', $item->behavior ?? '') }}</textarea>
            @error('behavior') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="substrate">Substrate</label>
            <textarea name="substrate" id="substrate" rows="2" class="input">{{ old('substrate', $item->substrate ?? '') }}</textarea>
            @error('substrate') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="preparations">Preparations</label>
            <textarea name="preparations" id="preparations" rows="2" class="input">{{ old('preparations', $item->preparations ?? '') }}</textarea>
            @error('preparations') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="associatedMedia">Associated media</label>
            <textarea name="associatedMedia" id="associatedMedia" rows="2" class="input">{{ old('associatedMedia', $item->associatedMedia ?? '') }}</textarea>
            @error('associatedMedia') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="associatedSequences">Associated sequences</label>
            <textarea name="associatedSequences" id="associatedSequences" rows="2" class="input">{{ old('associatedSequences', $item->associatedSequences ?? '') }}</textarea>
            @error('associatedSequences') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="associatedTaxa">Associated taxa</label>
            <textarea name="associatedTaxa" id="associatedTaxa" rows="2" class="input">{{ old('associatedTaxa', $item->associatedTaxa ?? '') }}</textarea>
            @error('associatedTaxa') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="otherCatalogNumbers">Other catalog numbers</label>
            <textarea name="otherCatalogNumbers" id="otherCatalogNumbers" rows="2" class="input">{{ old('otherCatalogNumbers', $item->otherCatalogNumbers ?? '') }}</textarea>
            @error('otherCatalogNumbers') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="occurrenceRemarks">Occurrence remarks</label>
            <textarea name="occurrenceRemarks" id="occurrenceRemarks" rows="2" class="input">{{ old('occurrenceRemarks', $item->occurrenceRemarks ?? '') }}</textarea>
            @error('occurrenceRemarks') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-success">Guardar Occurrence</button>
          <button type="button" id="btn-clear-all" class="btn btn-sm btn-outline-secondary">Limpiar borradores y vínculos</button>
        </div>

      </form>


       {{--------------- INICIO DE LA MODAL PARA EL PROCESO RECORD LEVEL ---------------------}}

        {{-- MODAL: Record Level --}}
        <div class="modal fade" id="modal-record-level" tabindex="-1" aria-hidden="true"> 
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header" style="background:#e7ab74;">
                <h5 class="modal-title">Record level1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                {{-- Buscar existentes --}}
                <div class="mb-3">
                  <input type="text" id="rl-search" class="form-control" placeholder="Buscar por ID o datasetName…">
                  <div id="rl-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Crear nuevo (AJAX) --}}
                <form id="rl-modal-form" action="{{ route('ajax.record-levels.store') }}" method="POST">
                  @csrf
                  @include('pages.record-level.partials.form', [
                    'item'                  => null,
                    'types'                 => $types,
                    'licenses'              => $licenses,
                    'rightsHolders'         => $rightsHolders,
                    'accessRights'          => $accessRights,
                    'institutionIds'        => $institutionIds,
                    'collectionIds'         => $collectionIds,
                    'institutionCodes'      => $institutionCodes,
                    'collectionCodes'       => $collectionCodes,
                    'ownerInstitutionCodes' => $ownerInstitutionCodes,
                    'basisOfRecords'        => $basisOfRecords,
                  ])
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        @push('scripts')
        <script>
        (function () {
          const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

          // Plantillas de rutas para Ver/Editar (resource web)
          const rlShowTpl = @json(route('record-level.show', '__ID__'));
          const rlEditTpl = @json(route('record-level.edit', '__ID__'));

          // Toast helper
          function showToast(message, variant = 'success') {
            const area = document.getElementById('toast-area');
            if (!area || !window.bootstrap) { alert(message); return; }

            const el = document.createElement('div');
            el.className = `toast align-items-center text-bg-${variant} border-0`;
            el.setAttribute('role','alert');
            el.setAttribute('aria-live','assertive');
            el.setAttribute('aria-atomic','true');
            el.innerHTML = `
              <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`;
            area.appendChild(el);

            const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
          }

          function forceUnlockUI() {
            // Elimina cualquier backdrop (incluye offcanvas)
            document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop')
              .forEach(b => b.remove());

            // Oculta y resetea cualquier modal que haya quedado visible
            document.querySelectorAll('.modal.show, .modal[style*="display: block"]').forEach(m => {
              try { bootstrap.Modal.getInstance(m)?.hide(); } catch(e) {}
              m.classList.remove('show');
              m.style.display = 'none';
              m.setAttribute('aria-hidden','true');
            });

            // Quita flags/clases/estilos que bloquean el scroll
            document.body.classList.remove('modal-open');
            document.documentElement.classList.remove('modal-open');
            ['overflow','padding-right','position','top','width'].forEach(p => {
              document.body.style.removeProperty(p);
              document.documentElement.style.removeProperty(p);
            });

            // Por si el foco quedó atrapado en un elemento oculto
            try { document.activeElement?.blur?.(); } catch(e) {}
          }

          // Cerrar modal (robusto)
          function closeModalById(id) {
            const el = document.getElementById(id);
            if (!el) return;

            // Usa la MISMA instancia que la abrió si existe
            let inst = window.bootstrap?.Modal.getInstance(el);
            if (!inst) inst = window.bootstrap?.Modal.getOrCreateInstance(el);

            // Al cerrarse, dispara limpieza final (una sola vez)
            el.addEventListener('hidden.bs.modal', () => forceUnlockUI(), { once: true });

            if (inst) {
              inst.hide();
            } else {
              // Fallback si no hay instancia válida
              el.classList.remove('show');
              el.style.display = 'none';
              el.setAttribute('aria-hidden','true');
              forceUnlockUI();
            }
          }

          // Seguridad extra global: si cualquier modal se oculta, limpia restos
          document.addEventListener('hidden.bs.modal', () => {
            // Si no queda ninguna visible, desbloquea
            if (!document.querySelector('.modal.show')) forceUnlockUI();
          });

          // Enlaza/visibiliza los links Ver/Editar según el ID actual
          function updateRlLinks(id) {
            const $actions = document.getElementById('rl-actions');
            const $view    = document.getElementById('rl-view');
            const $edit    = document.getElementById('rl-edit');

            if (id && $actions && $view && $edit) {
              $view.href = rlShowTpl.replace('__ID__', encodeURIComponent(id));
              $edit.href = rlEditTpl.replace('__ID__', encodeURIComponent(id));
              $actions.style.display = 'flex';
            } else if ($actions) {
              $actions.style.display = 'none';
            }
          }

          // Aplica id/label en el form principal, actualiza links y cierra modal
          function applyRecordLevel(id, label) {
            document.getElementById('record_level_id').value = id;
            const $label = document.getElementById('record_level_label');
            if ($label) $label.value = label || ('#'+id);
            const $sum = document.getElementById('summary-rl');
            if ($sum) $sum.textContent = label || ('#'+id);

            updateRlLinks(id);
            closeModalById('modal-record-level');
            window.unlockBodyScrollIfNoModal?.();

            // Persistencia opcional (autosave wizard)
            try {
              const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
              draft['record_level_id'] = id;
              localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

              const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
              links['record_level'] = { id, label: label || ('#'+id) };
              localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
            } catch {}
          }

          // Submit AJAX del formulario dentro de la modal
          const rlForm = document.getElementById('rl-modal-form');
          if (!rlForm) return;

          const submitBtn = rlForm.querySelector('button[type="submit"]');

          rlForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const originalHTML = submitBtn?.innerHTML;
            submitBtn?.setAttribute('disabled', 'disabled');
            if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

            try {
              const res = await fetch(rlForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json'
                },
                body: new FormData(rlForm)
              });

              if (!res.ok) {
                let msg = 'Error al guardar';
                try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                showToast(msg, 'danger');
                return;
              }

              const data = await res.json(); // { id, label? }
              applyRecordLevel(data.id, data.label);
              showToast('Record level guardado y asignado ✅', 'success');

            } catch (err) {
              showToast('Error de red o servidor.', 'danger');
            } finally {
              if (submitBtn) {
                submitBtn.innerHTML = originalHTML || 'Guardar y usar';
                submitBtn.removeAttribute('disabled');
              }
            }
          });

          // Buscador de existentes en la modal
          const $q = document.getElementById('rl-search');
          const $results = document.getElementById('rl-results');
          function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

          if ($q && $results) {
            const doSearch = debounce(async () => {
              const q = $q.value.trim();
              if (q.length < 2) { $results.innerHTML = ''; return; }

              const url = @json(route('ajax.record-levels.search')) + '?q=' + encodeURIComponent(q);
              const res = await fetch(url, { headers:{ 'Accept':'application/json' }, credentials:'same-origin' });
              const items = res.ok ? await res.json() : [];

              $results.innerHTML = items.length
                ? items.map(i =>
                  `<button type="button" class="list-group-item list-group-item-action"
                          data-id="${i.id}" data-label="${i.text}">
                    ${i.text} 
                  </button>`).join('')
                : '<div class="list-group-item text-muted">Sin resultados</div>';
            }, 300);

            $q.addEventListener('input', doSearch);

            $results.addEventListener('click', (e) => {
              const btn = e.target.closest('.list-group-item');
              if (!btn) return;
              applyRecordLevel(btn.dataset.id, btn.dataset.label);
              showToast('Record level asignado ✅');
            });
          }

          // Estado inicial: si ya había uno seleccionado, mostrar acciones Ver/Editar
          document.addEventListener('DOMContentLoaded', () => {
            const current = document.getElementById('record_level_id')?.value;
            if (current) updateRlLinks(current);
          });
        })();
        </script>
        @endpush


        {{--------------- FIN DEL PROCESO ---------------------}}

        {{--------------- INICIO DE LA MODAL PARA EL PROCESO ORGANISM ---------------------}}

        <div class="modal fade" id="modal-organism" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Organism — Buscar / Crear</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body">
                {{-- Buscador --}}
                <div class="mb-3">
                  <label class="label">Buscar Organism</label>
                  <input type="text" id="org-search" class="form-control" placeholder="ID, occurrences, organisms, identifications...">
                  <div id="org-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Form de creación/edición rápida --}}
                <form id="org-modal-form" action="{{ route('ajax.organisms.store') }}" method="POST">
                  @csrf

                   @include('pages.organism.partials.form', [
                      'item' => null,
                      'idPrefix' => 'ml_'
                  ])

                  <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        @push('scripts')
          <script>
          (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // Rutas Ver/Editar
            const orgShowTpl = @json(route('organism.show', '__ID__'));
            const orgEditTpl = @json(route('organism.edit', '__ID__'));

            // Helpers
            function showToast(message, variant = 'success') {
              const area = document.getElementById('toast-area');
              if (!area || !window.bootstrap) { alert(message); return; }
              const el = document.createElement('div');
              el.className = `toast align-items-center text-bg-${variant} border-0`;
              el.setAttribute('role','alert');
              el.setAttribute('aria-live','assertive');
              el.setAttribute('aria-atomic','true');
              el.innerHTML = `
                <div class="d-flex">
                  <div class="toast-body">${message}</div>
                  <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>`;
              area.appendChild(el);
              const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
              t.show();
              el.addEventListener('hidden.bs.toast', () => el.remove());
            }

            function closeModalById(id) {
              const el = document.getElementById(id);
              if (!el) return;
              let inst = window.bootstrap?.Modal.getInstance(el) || window.bootstrap?.Modal.getOrCreateInstance(el);
              if (inst) inst.hide();
              else {
                el.classList.remove('show'); el.style.display = 'none';
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('padding-right');
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
              }
            }

            function updateOrgLinks(id) {
              const $actions = document.getElementById('org-actions');
              const $view    = document.getElementById('org-view');
              const $edit    = document.getElementById('org-edit');

              if (id && $actions && $view && $edit) {
                $view.href = orgShowTpl.replace('__ID__', encodeURIComponent(id));
                $edit.href = orgEditTpl.replace('__ID__', encodeURIComponent(id));
                $actions.style.display = 'flex';
              } else if ($actions) {
                $actions.style.display = 'none';
              }
            }

            function applyOrganism(id, label) {
              document.getElementById('organismID').value = id;
              const $label = document.getElementById('organism_label');
              if ($label) $label.value = label || id;
              const $sum = document.getElementById('summary-org');
              if ($sum) $sum.textContent = label || id;

              updateOrgLinks(id);
              closeModalById('modal-organism');
              window.unlockBodyScrollIfNoModal?.();
              showToast('Organism guardado/asignado ✅', 'success');

              // Persistencia opcional (si usas autosave del wizard)
              try {
                const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
                draft['organismID'] = id;
                localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

                const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
                links['organism'] = { id, label: label || id };
                localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
              } catch {}
            }

            // Submit AJAX del form en la modal
            const orgForm   = document.getElementById('org-modal-form');
            const submitBtn = orgForm?.querySelector('button[type="submit"]');

            orgForm?.addEventListener('submit', async function (e) {
              e.preventDefault();

              const originalHTML = submitBtn?.innerHTML;
              submitBtn?.setAttribute('disabled','disabled');
              if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

              try {
                const res = await fetch(orgForm.action, {
                  method: 'POST',
                  credentials: 'same-origin',
                  headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                  },
                  body: new FormData(orgForm)
                });

                if (!res.ok) {
                  let msg = 'Error al guardar';
                  try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                  showToast(msg, 'danger');
                  return;
                }

                const data = await res.json(); // { id, label }
                applyOrganism(data.id, data.label);

              } catch (err) {
                showToast('Error de red o servidor.', 'danger');
              } finally {
                if (submitBtn) {
                  submitBtn.innerHTML = originalHTML || 'Guardar y usar';
                  submitBtn.removeAttribute('disabled');
                }
              }
            });

            // Buscador en la modal
            const $q = document.getElementById('org-search');
            const $results = document.getElementById('org-results');

            function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

            if ($q && $results) {
              const doSearch = debounce(async () => {
                const q = $q.value.trim();
                if (q.length < 2) { $results.innerHTML = ''; return; }

                const url = @json(route('ajax.organisms.search')) + '?q=' + encodeURIComponent(q);
                const res = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials:'same-origin' });
                const items = res.ok ? await res.json() : [];

                $results.innerHTML = (items && items.length && items[0].id !== '')
                  ? items.map(i => `
                      <button type="button" class="list-group-item list-group-item-action"
                              data-id="${i.id}" data-label="${i.text}">
                        ${i.text}
                      </button>`).join('')
                  : '<div class="list-group-item text-muted">Sin resultados</div>';
              }, 300);

              $q.addEventListener('input', doSearch);

              $results.addEventListener('click', (e) => {
                const btn = e.target.closest('.list-group-item');
                if (!btn) return;
                applyOrganism(btn.dataset.id, btn.dataset.label);
                showToast('Organism asignado ✅');
              });
            }

            // Estado inicial: si ya existe organismID, mostrar acciones
            document.addEventListener('DOMContentLoaded', () => {
              const current = document.getElementById('organismID')?.value;
              if (current) updateOrgLinks(current);
            });
          })();
          </script>
        @endpush


        {{--------------- FIN DEL PROCESO ---------------------}}

        {{--------------- INICIO DE LA MODAL PARA EL PROCESO LOCATION ---------------------}}

        <div class="modal fade" id="modal-location" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Location — Buscar / Crear</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body">
                {{-- Buscador --}}
                <div class="mb-3">
                  <label class="label">Buscar Location</label>
                  <input type="text" id="loc-search" class="form-control" placeholder="ID, locality, country, state/province…">
                  <div id="loc-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Modal Location (sólo cambio el cuerpo del <form>) --}}
                <form id="loc-modal-form" action="{{ route('ajax.locations.store') }}" method="POST">
                  @csrf

                  {{-- Reutilizamos el partial con TODOS los campos.
                      - idPrefix solo afecta los "id" y "for" (NO los "name"), para evitar colisiones de IDs.
                      - $item = null porque es creación rápida en modal.
                  --}}
                  @include('pages.location.partials.form', [
                      'item' => null,
                      'idPrefix' => 'ml_'
                  ])

                  <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        @push('scripts')
        <script>
        (function () {
          const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

          // Rutas Ver/Editar
          const locShowTpl = @json(route('location.show', '__ID__'));
          const locEditTpl = @json(route('location.edit', '__ID__'));

          // Helpers
          function showToast(message, variant = 'success') {
            const area = document.getElementById('toast-area');
            if (!area || !window.bootstrap) { alert(message); return; }
            const el = document.createElement('div');
            el.className = `toast align-items-center text-bg-${variant} border-0`;
            el.setAttribute('role','alert');
            el.setAttribute('aria-live','assertive');
            el.setAttribute('aria-atomic','true');
            el.innerHTML = `
              <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
              </div>`;
            area.appendChild(el);
            const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
          }

          function closeModalById(id) {
            const el = document.getElementById(id);
            if (!el) return;
            let inst = window.bootstrap?.Modal.getInstance(el) || window.bootstrap?.Modal.getOrCreateInstance(el);
            if (inst) inst.hide();
            else {
              el.classList.remove('show'); el.style.display = 'none';
              document.body.classList.remove('modal-open');
              document.body.style.removeProperty('padding-right');
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }
          }

          function updateLocLinks(id) {
            const $actions = document.getElementById('loc-actions');
            const $view    = document.getElementById('loc-view');
            const $edit    = document.getElementById('loc-edit');

            if (id && $actions && $view && $edit) {
              $view.href = locShowTpl.replace('__ID__', encodeURIComponent(id));
              $edit.href = locEditTpl.replace('__ID__', encodeURIComponent(id));
              $actions.style.display = 'flex';
            } else if ($actions) {
              $actions.style.display = 'none';
            }
          }

          function applyLocation(id, label) {
            document.getElementById('locationID').value = id;
            const $label = document.getElementById('location_label');
            if ($label) $label.value = label || id;
            const $sum = document.getElementById('summary-loc');
            if ($sum) $sum.textContent = label || id;

            updateLocLinks(id);
            closeModalById('modal-location');
            window.unlockBodyScrollIfNoModal?.();
            showToast('Location guardada/asignada ✅', 'success');

            // Persistencia opcional (autosave wizard)
            try {
              const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
              draft['locationID'] = id;
              localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

              const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
              links['location'] = { id, label: label || id };
              localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
            } catch {}
          }

          // Submit AJAX del form en la modal
          const locForm   = document.getElementById('loc-modal-form');
          const submitBtn = locForm?.querySelector('button[type="submit"]');

          locForm?.addEventListener('submit', async function (e) {
            e.preventDefault();

            const originalHTML = submitBtn?.innerHTML;
            submitBtn?.setAttribute('disabled','disabled');
            if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

            try {
              const res = await fetch(locForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json'
                },
                body: new FormData(locForm)
              });

              if (!res.ok) {
                let msg = 'Error al guardar';
                try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                showToast(msg, 'danger');
                return;
              }

              const data = await res.json(); // { id, label }
              applyLocation(data.id, data.label);

            } catch (err) {
              showToast('Error de red o servidor.', 'danger');
            } finally {
              if (submitBtn) {
                submitBtn.innerHTML = originalHTML || 'Guardar y usar';
                submitBtn.removeAttribute('disabled');
              }
            }
          });

          // Buscador en la modal
          const $q = document.getElementById('loc-search');
          const $results = document.getElementById('loc-results');

          function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

          if ($q && $results) {
            const doSearch = debounce(async () => {
              const q = $q.value.trim();
              if (q.length < 2) { $results.innerHTML = ''; return; }

              const url = @json(route('ajax.locations.search')) + '?q=' + encodeURIComponent(q);
              const res = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials:'same-origin' });
              const items = res.ok ? await res.json() : [];

              $results.innerHTML = (items && items.length && items[0].id !== '')
                ? items.map(i => `
                    <button type="button" class="list-group-item list-group-item-action"
                            data-id="${i.id}" data-label="${i.text}">
                      ${i.text}
                    </button>`).join('')
                : '<div class="list-group-item text-muted">Sin resultados</div>';
            }, 300);

            $q.addEventListener('input', doSearch);

            $results.addEventListener('click', (e) => {
              const btn = e.target.closest('.list-group-item');
              if (!btn) return;
              applyLocation(btn.dataset.id, btn.dataset.label);
              showToast('Location asignada ✅');
            });
          }

          // Estado inicial: si ya existe locationID, mostrar acciones
          document.addEventListener('DOMContentLoaded', () => {
            const current = document.getElementById('locationID')?.value;
            if (current) updateLocLinks(current);
          });
        })();
        </script>
        @endpush

      {{--------------- FIN DEL PROCESO ---------------------}}

      {{--------------- INICIO DE LA MODAL PARA EL PROCESO TAXON ---------------------}}

        <div class="modal fade" id="modal-taxon" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Taxon — Buscar / Crear</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body">

                {{-- Buscador --}}
                <div class="mb-3">
                  <label class="label">Buscar Taxon</label>
                  <input type="text" id="tax-search" class="form-control" placeholder="ID, scientificName, genus, family, kingdom…">
                  <div id="tax-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Form AJAX de creación/edición rápida --}}
                <form id="tax-modal-form" action="{{ route('ajax.taxa.store') }}" method="POST">
                  @csrf

                  @if (View::exists('pages.taxon.partials.form'))
                    {{-- Reutiliza tu partial completo (todos los campos) --}}
                    @include('pages.taxon.partials.form', [
                      'item' => null,
                      'idPrefix' => 'mt_',
                      // si tu partial requiere $taxonRanks, $taxStatuses deben venir del controlador
                    ])
                  @else
                    {{-- Versión mínima si no tienes partial --}}
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label class="label" for="mt_taxonID">Taxon ID (vacío = auto)</label>
                        <input type="text" name="taxonID" id="mt_taxonID" class="form-control">
                      </div>
                      <div class="col-md-8">
                        <label class="label" for="mt_scientificName">Scientific name *</label>
                        <input type="text" name="scientificName" id="mt_scientificName" class="form-control" required>
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mt_taxonRank">Taxon rank</label>
                        <select name="taxonRank" id="mt_taxonRank" class="form-control">
                          <option value="">— Selecciona —</option>
                          @foreach($taxonRanks as $opt) {{-- taxonRank_id, taxonRank_value --}}
                            <option value="{{ $opt->taxonRank_id }}">{{ $opt->taxonRank_value }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="label" for="mt_taxonomicStatus">Taxonomic status</label>
                        <select name="taxonomicStatus" id="mt_taxonomicStatus" class="form-control">
                          <option value="">— Selecciona —</option>
                          @foreach($taxStatuses as $opt) {{-- taxonomicStatus_id, taxonomicStatus_value --}}
                            <option value="{{ $opt->taxonomicStatus_id }}">{{ $opt->taxonomicStatus_value }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mt_genus">Genus</label>
                        <input type="text" name="genus" id="mt_genus" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label class="label" for="mt_family">Family</label>
                        <input type="text" name="family" id="mt_family" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label class="label" for="mt_kingdom">Kingdom</label>
                        <input type="text" name="kingdom" id="mt_kingdom" class="form-control">
                      </div>
                    </div>
                  @endif

                  <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>

        @push('scripts')
        <script>
        (function () {
          const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

          // Rutas Ver/Editar
          const taxShowTpl = @json(route('taxon.show', '__ID__'));
          const taxEditTpl = @json(route('taxon.edit', '__ID__'));

          function showToastTaxon(message, variant = 'success') {
            const area = document.getElementById('toast-area');
            if (!area || !window.bootstrap) { alert(message); return; }
            const el = document.createElement('div');
            el.className = `toast align-items-center text-bg-${variant} border-0`;
            el.setAttribute('role','alert');
            el.setAttribute('aria-live','assertive');
            el.setAttribute('aria-atomic','true');
            el.innerHTML = `
              <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
              </div>`;
            area.appendChild(el);
            const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
          }

          function closeTaxonModal() {
            const el = document.getElementById('modal-taxon');
            if (!el) return;
            let inst = window.bootstrap?.Modal.getInstance(el) || window.bootstrap?.Modal.getOrCreateInstance(el);
            if (inst) inst.hide(); else {
              el.classList.remove('show'); el.style.display = 'none';
              document.body.classList.remove('modal-open');
              document.body.style.removeProperty('padding-right');
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }
          }

          function updateTaxLinks(id) {
            const box = document.getElementById('tax-actions');
            const v = document.getElementById('tax-view');
            const e = document.getElementById('tax-edit');
            if (box && v && e && id) {
              v.href = taxShowTpl.replace('__ID__', encodeURIComponent(id));
              e.href = taxEditTpl.replace('__ID__', encodeURIComponent(id));
              box.style.display = 'flex';
            } else if (box) {
              box.style.display = 'none';
            }
          }

          function closeModalById(id) {
            const el = document.getElementById(id);
            if (!el) return;
            let inst = window.bootstrap?.Modal.getInstance(el) || window.bootstrap?.Modal.getOrCreateInstance(el);
            if (inst) inst.hide();
            else {
              el.classList.remove('show'); el.style.display = 'none';
              document.body.classList.remove('modal-open');
              document.body.style.removeProperty('padding-right');
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }
          }

          function applyTaxon(id, label) {
            document.getElementById('taxonID').value = id;
            const $label = document.getElementById('taxon_label');
            if ($label) $label.value = label || id;
            const $sum = document.getElementById('summary-tax');
            if ($sum) $sum.textContent = label || id;

            updateTaxLinks(id);
            closeTaxonModal();
            closeModalById('modal-taxon');

            window.unlockBodyScrollIfNoModal?.(); 
            showToastTaxon('Taxon guardado/asignado ✅','success');

            // Persistencia opcional
            try {
              const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
              draft['taxonID'] = id;
              localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

              const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
              links['taxon'] = { id, label: label || id };
              localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
            } catch {}
          }

          // Submit AJAX del form de la modal
          const taxForm = document.getElementById('tax-modal-form');
          const submitBtn = taxForm?.querySelector('button[type="submit"]');

          taxForm?.addEventListener('submit', async function (e) {
            e.preventDefault();
            const original = submitBtn?.innerHTML;
            submitBtn?.setAttribute('disabled','disabled');
            if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

            try {
              const res = await fetch(taxForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json'
                },
                body: new FormData(taxForm)
              });

              if (!res.ok) {
                let msg = 'Error al guardar';
                try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                showToastTaxon(msg,'danger');
                return;
              }

              const data = await res.json(); // { id, label }
              applyTaxon(data.id, data.label);

            } catch (err) {
              showToastTaxon('Error de red o servidor.','danger');
            } finally {
              if (submitBtn) {
                submitBtn.innerHTML = original || 'Guardar y usar';
                submitBtn.removeAttribute('disabled');
              }
            }
          });

          // Buscador
          const $q = document.getElementById('tax-search');
          const $results = document.getElementById('tax-results');
          function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

          if ($q && $results) {

            const doSearch = debounce(async () => {
              const q = $q.value.trim();
              if (q.length < 2) { $results.innerHTML = ''; return; }

              const url = @json(route('ajax.taxa.search')) + '?q=' + encodeURIComponent(q);
              const res = await fetch(url, { headers:{'Accept':'application/json'}, credentials:'same-origin' });
              const items = res.ok ? await res.json() : [];

              $results.innerHTML = (items && items.length && items[0].id !== '')
                ? items.map(i => `
                    <button type="button" class="list-group-item list-group-item-action"
                            data-id="${i.id}" data-label="${i.text}">
                      ${i.text}
                    </button>`).join('')
                : '<div class="list-group-item text-muted">Sin resultados</div>';
            }, 300);

            $q.addEventListener('input', doSearch);

            $results.addEventListener('click', (e) => {
              const btn = e.target.closest('.list-group-item');
              if (!btn) return;
              applyTaxon(btn.dataset.id, btn.dataset.label);
              showToastTaxon('Taxon asignado ✅');
            });
          }

          // Estado inicial (si ya hay taxonID)
          document.addEventListener('DOMContentLoaded', () => {
            const current = document.getElementById('taxonID')?.value;
            if (current) updateTaxLinks(current);
          });
        })();
        </script>
      @endpush

      {{--------------- FIN DEL PROCESO ---------------------}}  


      {{--------------- INICIO DE LA MODAL PARA EL PROCESO IDENTIFICATION ---------------------}}  

        <div class="modal fade" id="modal-identification" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Identification — Buscar / Crear</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body">
                {{-- Buscador --}}
                <div class="mb-3">
                  <label class="label">Buscar Identification</label>
                  <input type="text" id="idn-search" class="form-control"
                        placeholder="ID, identifiedBy, remarks…">
                  <div id="idn-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Form AJAX --}}
                <form id="idn-modal-form" action="{{ route('ajax.identifications.store') }}" method="POST">
                  @csrf
                  @if (View::exists('pages.identification.partials.form'))
                    {{-- Reutiliza partial completo con TODOS los campos --}}
                    @include('pages.identification.partials.form', [
                      'item' => null,
                      'idPrefix' => 'mi_',  // prefijo para evitar choque de IDs
                      // si tu partial requiere $typeStatuses y $verificationStatuses, pásalos desde el controlador
                    ])
                  @else
                    {{-- Versión mínima si aún no tienes partial --}}
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label class="label" for="mi_identificationID">Identification ID (vacío = auto)</label>
                        <input type="text" name="identificationID" id="mi_identificationID" class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mi_identifiedBy">Identified by</label>
                        <input type="text" name="identifiedBy" id="mi_identifiedBy" class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mi_dateIdentified">Date identified</label>
                        <input type="date" name="dateIdentified" id="mi_dateIdentified" class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mi_identificationQualifier">Identification qualifier</label>
                        <input type="text" name="identificationQualifier" id="mi_identificationQualifier" class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mi_typeStatus">Type status</label>
                        <select name="typeStatus" id="mi_typeStatus" class="form-control">
                          <option value="">— Selecciona —</option>
                          @foreach($typeStatuses as $opt)
                            <option value="{{ $opt->vocab_identification_typeStatus_id }}">{{ $opt->typeStatus_value }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="col-md-4">
                        <label class="label" for="mi_identificationVerificationStatus">Verification status</label>
                        <select name="identificationVerificationStatus" id="mi_identificationVerificationStatus" class="form-control">
                          <option value="">— Selecciona —</option>
                          @foreach($verificationStatuses as $opt)
                            <option value="{{ $opt->vocab_identification_verificationStatus_id }}">
                              {{ $opt->identificationVerificationStatus_value }}
                            </option>
                          @endforeach
                        </select>
                      </div>

                      <div class="col-12">
                        <label class="label" for="mi_identificationRemarks">Remarks</label>
                        <textarea name="identificationRemarks" id="mi_identificationRemarks" rows="2" class="form-control"></textarea>
                      </div>
                    </div>
                  @endif

                  <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        @push('scripts')
          <script>
          (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // Rutas Ver/Editar
            const idnShowTpl = @json(route('identification.show', '__ID__'));
            const idnEditTpl = @json(route('identification.edit', '__ID__'));

            function toastIdn(message, variant='success') {
              const area = document.getElementById('toast-area');
              if (!area || !window.bootstrap) { alert(message); return; }
              const el = document.createElement('div');
              el.className = `toast align-items-center text-bg-${variant} border-0`;
              el.setAttribute('role','alert'); el.setAttribute('aria-live','assertive'); el.setAttribute('aria-atomic','true');
              el.innerHTML = `<div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
              </div>`;
              area.appendChild(el);
              const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
              t.show(); el.addEventListener('hidden.bs.toast', () => el.remove());
            }

            document.addEventListener('hidden.bs.modal', () => {
              if (!document.querySelector('.modal.show')) {
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('padding-right');
              }
            });

            function closeIdnModal() {
              closeModalById('modal-identification');
            }

            function closeModalById(id) {
              const el = document.getElementById(id);
              if (!el) return;

              // Intenta usar la misma instancia que abrió la modal
              let inst = window.bootstrap?.Modal.getInstance(el);
              if (!inst) inst = window.bootstrap?.Modal.getOrCreateInstance(el);

              // Al cerrarse definitivamente, limpia backdrop/clases restantes
              el.addEventListener('hidden.bs.modal', () => {
                if (!document.querySelector('.modal.show')) { // si no quedan modales visibles
                  document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                  document.body.classList.remove('modal-open');
                  document.body.style.removeProperty('padding-right');
                }
              }, { once: true });

              // Ejecuta el cierre
              if (inst) inst.hide();
              else {
                // Fallback, por si no hay instancia (dobles versiones de Bootstrap, etc.)
                el.classList.remove('show');
                el.style.display = 'none';
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('padding-right');
              }

              // Saca el foco de elementos que aún puedan quedar “atrapados”
              document.activeElement?.blur?.();
            }

            function updateIdnLinks(id) {
              const box = document.getElementById('idn-actions');
              const v = document.getElementById('idn-view');
              const e = document.getElementById('idn-edit');
              if (box && v && e && id) {
                v.href = idnShowTpl.replace('__ID__', encodeURIComponent(id));
                e.href = idnEditTpl.replace('__ID__', encodeURIComponent(id));
                box.style.display = 'flex';
              } else if (box) {
                box.style.display = 'none';
              }
            }

            function applyIdentification(id, label) {
              document.getElementById('identificationID').value = id;
              const $label = document.getElementById('identification_label');
              if ($label) $label.value = label || id;
              const $sum = document.getElementById('summary-id');
              if ($sum) $sum.textContent = label || id;

              updateIdnLinks(id);

              // ⬇️ Cierre robusto + limpieza
              closeModalById('modal-identification');
              window.unlockBodyScrollIfNoModal?.();

              toastIdn('Identification guardada/asignada ✅','success');

              try {
                const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
                draft['identificationID'] = id;
                localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

                const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
                links['identification'] = { id, label: label || id };
                localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
              } catch {}
            }

            // Submit AJAX
            const idnForm = document.getElementById('idn-modal-form');
            const submitBtn = idnForm?.querySelector('button[type="submit"]');

            idnForm?.addEventListener('submit', async function(e){
              e.preventDefault();
              const original = submitBtn?.innerHTML;
              submitBtn?.setAttribute('disabled','disabled');
              if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

              try {
                const res = await fetch(idnForm.action, {
                  method: 'POST',
                  credentials: 'same-origin',
                  headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' },
                  body: new FormData(idnForm)
                });

                if (!res.ok) {
                  let msg = 'Error al guardar';
                  try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                  toastIdn(msg, 'danger');
                  return;
                }

                const data = await res.json(); // { id, label }
                applyIdentification(data.id, data.label);

              } catch (err) {
                toastIdn('Error de red o servidor.','danger');
              } finally {
                if (submitBtn) { submitBtn.innerHTML = original || 'Guardar y usar'; submitBtn.removeAttribute('disabled'); }
              }
            });

            // Buscador
            const $q = document.getElementById('idn-search');
            const $results = document.getElementById('idn-results');
            function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

            if ($q && $results) {
              const doSearch = debounce(async () => {
                const q = $q.value.trim();
                if (q.length < 2) { $results.innerHTML = ''; return; }

                const url = @json(route('ajax.identifications.search')) + '?q=' + encodeURIComponent(q);
                const res = await fetch(url, { headers:{ 'Accept':'application/json' }, credentials:'same-origin' });
                const items = res.ok ? await res.json() : [];

                $results.innerHTML = (items && items.length && items[0].id !== '')
                  ? items.map(i => `
                      <button type="button" class="list-group-item list-group-item-action"
                              data-id="${i.id}" data-label="${i.text}">
                        ${i.text}
                      </button>`).join('')
                  : '<div class="list-group-item text-muted">Sin resultados</div>';
              }, 300);

              $q.addEventListener('input', doSearch);

              $results.addEventListener('click', (e) => {
                const btn = e.target.closest('.list-group-item'); if (!btn) return;
                applyIdentification(btn.dataset.id, btn.dataset.label);
                toastIdn('Identification asignada ✅');
              });
            }

            // Estado inicial
            document.addEventListener('DOMContentLoaded', () => {
              const current = document.getElementById('identificationID')?.value;
              if (current) updateIdnLinks(current);
            });
          })();
          </script>
        @endpush



      {{--------------- FIN DEL PROCESO ---------------------}}


      {{---------- INICIO DE SCRIPTS PARA POBLAR LOS COMBOS CON DATA DE LOCALSTORAGE -------}}  
      
      @push('scripts')
      <script>
      (function () {
        // Claves usadas para guardar borradores y “selecciones vinculadas”
        const DRAFT_KEY = 'occ_wizard_occurrence_v2';
        const LINKS_KEY = 'occ_wizard_links_v2';

        // Mapea cada “pieza” a sus IDs de input (hidden + visible label) y a claves en storage
        const FIELDS = [
          {
            kind: 'record_level',
            hiddenId: 'record_level_id',
            labelId:  'record_level_label',
            summaryId:'summary-rl',
            // Cómo se llama en draft (autosave) y en links (selección)
            draftKey: 'record_level_id',
            linkKey:  'record_level',
            makeFallbackLabel: id => '#'+id
          },
          {
            kind: 'organism',
            hiddenId: 'organismID',
            labelId:  'organism_label',
            summaryId:'summary-org',
            draftKey: 'organismID',
            linkKey:  'organism',
            makeFallbackLabel: id => id
          },
          {
            kind: 'location',
            hiddenId: 'locationID',
            labelId:  'location_label',
            summaryId:'summary-loc',
            draftKey: 'locationID',
            linkKey:  'location',
            makeFallbackLabel: id => id
          },
          {
            kind: 'taxon',
            hiddenId: 'taxonID',
            labelId:  'taxon_label',
            summaryId:'summary-tax',
            draftKey: 'taxonID',
            linkKey:  'taxon',
            makeFallbackLabel: id => id
          },
          {
            kind: 'identification',
            hiddenId: 'identificationID',
            labelId:  'identification_label',
            summaryId:'summary-id',
            draftKey: 'identificationID',
            linkKey:  'identification',
            makeFallbackLabel: id => id
          }

        ];

        function getEl(id){ return document.getElementById(id); }
        function setVal(id, v){ const el=getEl(id); if(el) el.value=(v??''); }
        function setTxt(id, t){ const el=getEl(id); if(el) el.textContent=(t??'—'); }

        function rehydrate() {
          let draft={}, links={};
          try { draft = JSON.parse(localStorage.getItem(DRAFT_KEY) || '{}'); } catch {}
          try { links = JSON.parse(localStorage.getItem(LINKS_KEY) || '{}'); } catch {}

          FIELDS.forEach(cfg => {
            const hiddenEl = getEl(cfg.hiddenId);
            const labelEl  = getEl(cfg.labelId);

            // 1) Si ya hay valor en el input hidden, lo respetamos y fabricamos un label si falta
            let id = hiddenEl?.value?.trim() || '';

            // 2) Si no hay id en el input, intentamos desde links (tiene {id,label})
            if (!id && links[cfg.linkKey]?.id) {
              id = (links[cfg.linkKey].id || '').trim();
            }

            // 3) Si todavía no hay id, probamos en draft (autosave)
            if (!id && draft[cfg.draftKey]) {
              id = (''+draft[cfg.draftKey]).trim();
            }

            // Si conseguimos un ID, calculamos el label (links trae label; si no, fabricamos)
            if (id) {
              const storedLabel = (links[cfg.linkKey]?.label || '').trim();
              const label = storedLabel || cfg.makeFallbackLabel(id);

              setVal(cfg.hiddenId, id);
              setVal(cfg.labelId, label);
              setTxt(cfg.summaryId, label);
            } else {
              // No hay nada que mostrar
              setVal(cfg.hiddenId, '');
              setVal(cfg.labelId, '');
              setTxt(cfg.summaryId, '—');
            }
          });
        }

        // Ejecuta al cargar el DOM
        document.addEventListener('DOMContentLoaded', rehydrate);
        // Fallback por si el DOMContentLoaded se dispara antes de que tus inputs existan
        window.addEventListener('load', rehydrate);
      })();
      </script>
      @endpush

     {{---------- FIN DE SCRIPTS PARA VALIDAR CAMPOS HIDDEN -------}}    


    </div>

    {{-- ============ TAB 2: RECORD LEVEL (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-record-level" role="tabpanel">
      <form id="rl-form" action="{{ route('ajax.record-levels.store') }}" method="POST">
        @csrf
        @include('pages.record-level.partials.form', [
          'item'                 => null,
          'types'                => $types,
          'licenses'             => $licenses,
          'rightsHolders'        => $rightsHolders,
          'accessRights'         => $accessRights,
          'institutionIds'       => $institutionIds,
          'collectionIds'        => $collectionIds,
          'institutionCodes'     => $institutionCodes,
          'collectionCodes'      => $collectionCodes,
          'ownerInstitutionCodes'=> $ownerInstitutionCodes,
          'basisOfRecords'       => $basisOfRecords,
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 3: ORGANISM (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-organism" role="tabpanel">
      <form id="organism-form">
        @csrf
        @include('pages.organism.partials.form', ['item' => null])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 4: LOCATION (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-location" role="tabpanel">
      <form id="location-form">
        @csrf
        @include('pages.location.partials.form', [
          'item'           => null,
          'continents'     => $continents ?? collect(),
          'verbatimSrs'    => $verbatimSrs ?? collect(),
          'georefStatuses' => $georefStatuses ?? collect(),
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 5: TAXON (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-taxon" role="tabpanel">
      <form id="taxon-form">
        @csrf
        @include('pages.taxon.partials.form', [
          'item'              => null,
          'taxonRanks'        => $taxonRanks ?? collect(),
          'taxonomicStatuses' => $taxonomicStatuses ?? collect(),
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 6: IDENTIFICATION (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-identification" role="tabpanel">
      <form id="identification-form">
        @csrf
        @include('pages.identification.partials.form', [
          'item'             => null,
          'idTypeStatuses'   => $idTypeStatuses ?? collect(),
          'idVerifStatuses'  => $idVerifStatuses ?? collect(),
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
(function () {
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Helpers
  async function postForm(form, url, onOk) {
    const fd = new FormData(form);
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: fd
    });
    if (!res.ok) { alert('Error al guardar'); return; }
    const data = await res.json();
    if (typeof onOk === 'function') onOk(data.id, data);
  }

  function showTabOccurrence() {
    const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
    if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
  }

  function setHiddenAndSummary(inputId, value, summaryId, label) {
    const $in = document.getElementById(inputId);
    if ($in) $in.value = value;
    const $sum = document.getElementById(summaryId);
    if ($sum) $sum.textContent = label || value || '—';
  }

  // 1) Record level
  const rlForm = document.getElementById('rl-form');
  if (rlForm) {
    rlForm.addEventListener('submit', function (e) {
      e.preventDefault(); // <-- evita refresco
      postForm(rlForm, rlForm.action, function (id, data) {
        setHiddenAndSummary('record_level_id', id, 'summary-rl', data.label || ('#'+id));
        alert('Record level guardado y asignado 2: ' + id);
        showTabOccurrence();
      });
    });
  }
  // 2) Organism
  const orgForm = document.getElementById('organism-form');
  if (orgForm) {
    orgForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(orgForm, @json(route('ajax.organisms.store')), function (id, data) {
        setHiddenAndSummary('organismID', id, 'summary-org', data.label || id);
        alert('Organism guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }

  // 3) Location
  const locForm = document.getElementById('location-form');
  if (locForm) {
    locForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(locForm, @json(route('ajax.locations.store')), function (id, data) {
        setHiddenAndSummary('locationID', id, 'summary-loc', data.label || id);
        alert('Location guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }

  // 4) Taxon
  const taxForm = document.getElementById('taxon-form');
  if (taxForm) {
    taxForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(taxForm, @json(route('ajax.taxa.store')), function (id, data) {
        setHiddenAndSummary('taxonID', id, 'summary-tax', data.label || id);
        alert('Taxon guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }

  // 5) Identification
  const idForm = document.getElementById('identification-form');
  if (idForm) {
    idForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(idForm, @json(route('ajax.identifications.store')), function (id, data) {
        setHiddenAndSummary('identificationID', id, 'summary-id', data.label || id);
        alert('Identification guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }
})();
</script>
@endpush

@push('scripts')
<script>
(function () {
  // ====== Claves de almacenamiento ======
  const KEY_OCC   = 'occ_wizard_occurrence_v2';
  const KEY_RL    = 'occ_wizard_record_level_v2';
  const KEY_ORG   = 'occ_wizard_organism_v2';
  const KEY_LOC   = 'occ_wizard_location_v2';
  const KEY_TAX   = 'occ_wizard_taxon_v2';
  const KEY_ID    = 'occ_wizard_identification_v2';
  const KEY_TAB   = 'occ_wizard_active_v2';
  const KEY_LINKS = 'occ_wizard_links_v2'; // { record_level: {id,label}, organism: {...}, ... }

  // ====== Utilidades ======
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  function debounce(fn, ms) {
    let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
  }

  function serializeForm(root) {
    const out = {};
    const fields = root.querySelectorAll('input[name], select[name], textarea[name]');
    fields.forEach(el => {
      if (el.disabled) return;
      if (el.type === 'file') return;
      const name = el.name;
      if (el.type === 'checkbox') {
        if (!out[name]) out[name] = [];
        if (el.checked) out[name].push(el.value || 'on');
      } else if (el.type === 'radio') {
        if (el.checked) out[name] = el.value;
      } else if (el.tagName === 'SELECT' && el.multiple) {
        out[name] = Array.from(el.selectedOptions).map(o => o.value);
      } else {
        out[name] = el.value;
      }
    });
    return out;
  }

  function restoreForm(root, data) {
    const fields = root.querySelectorAll('input[name], select[name], textarea[name]');
    fields.forEach(el => {
      const name = el.name;
      if (!(name in data)) return;
      if (el.type === 'checkbox') {
        const arr = Array.isArray(data[name]) ? data[name] : [data[name]];
        el.checked = arr.includes(el.value || 'on');
      } else if (el.type === 'radio') {
        el.checked = data[name] === el.value;
      } else if (el.tagName === 'SELECT' && el.multiple) {
        const arr = Array.isArray(data[name]) ? data[name] : [data[name]];
        Array.from(el.options).forEach(o => o.selected = arr.includes(o.value));
      } else {
        el.value = data[name] ?? '';
      }
      el.dispatchEvent(new Event('change', { bubbles: true }));
    });
  }

  function getJSON(key, fallback = {}) {
    try { return JSON.parse(localStorage.getItem(key) || '') ?? fallback; }
    catch { return fallback; }
  }
  function setJSON(key, value) { localStorage.setItem(key, JSON.stringify(value)); }

  // ====== Resumen + vínculos (hidden + spans) ======
  const SELECT_MAP = {
    record_level: { input: 'record_level_id', summary: 'summary-rl'  },
    organism:     { input: 'organismID',       summary: 'summary-org' },
    location:     { input: 'locationID',       summary: 'summary-loc' },
    taxon:        { input: 'taxonID',          summary: 'summary-tax' },
    identification:{input: 'identificationID', summary: 'summary-id'  },
  };

  function setLink(kind, id, label) {
    const cfg = SELECT_MAP[kind]; if (!cfg) return;
    // hidden
    const $in = document.getElementById(cfg.input);
    if ($in) $in.value = id || '';
    // resumen
    const $sum = document.getElementById(cfg.summary);
    if ($sum) $sum.textContent = label || id || '—';

    // Persistir selección
    const links = getJSON(KEY_LINKS, {});
    links[kind] = { id, label };
    setJSON(KEY_LINKS, links);

    // Reflejar también en el borrador del form Occurrence (para no perder al F5)
    const occDraft = getJSON(KEY_OCC, {});
    occDraft[cfg.input] = id;
    setJSON(KEY_OCC, occDraft);
  }

  function restoreLinks() {
    const links = getJSON(KEY_LINKS, {});
    for (const [kind, v] of Object.entries(links)) {
      if (v && typeof v === 'object') setLink(kind, v.id, v.label);
    }
  }

  // ====== Autosave genérico por formulario ======
  let dirty = false; // alerta al salir

  function registerAutosave(formSelector, storageKey) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    // Restaurar
    const draft = getJSON(storageKey, {});
    if (Object.keys(draft).length) restoreForm(form, draft);

    // Guardar
    const save = debounce(() => {
      const data = serializeForm(form);
      setJSON(storageKey, data);
      dirty = true;
    }, 250);
    form.addEventListener('input',  save);
    form.addEventListener('change', save);

  }

  // Registrar autosave para TODOS los tabs
  registerAutosave('#occ-form',        KEY_OCC);
  registerAutosave('#rl-form',         KEY_RL);
  registerAutosave('#organism-form',   KEY_ORG);
  registerAutosave('#location-form',   KEY_LOC);
  registerAutosave('#taxon-form',      KEY_TAX);
  registerAutosave('#identification-form', KEY_ID);

  // ====== Restaurar links (resumen e inputs ocultos) al cargar ======
  restoreLinks();

  // ====== Recordar tab activo ======
  document.querySelectorAll('[data-bs-toggle="tab"]').forEach(el => {
    el.addEventListener('shown.bs.tab', (e) => {
      const targetSel = e.target?.getAttribute('data-bs-target') || e.target?.getAttribute('href');
      if (targetSel) localStorage.setItem(KEY_TAB, targetSel);
    });
  });
  const savedTab = localStorage.getItem(KEY_TAB);
  if (savedTab) {
    const trigger = document.querySelector(`[data-bs-target="${savedTab}"], a[href="${savedTab}"]`);
    if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
  }

  // ====== Interceptar submit de subforms (AJAX) y fijar vínculos ======
  async function postForm(form, onOk) {
    const res = await fetch(form.action, {
      method: form.method || 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: new FormData(form),
    });
    if (!res.ok) {
      let msg = 'Error al guardar';
      try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
      alert(msg);
      return;
    }
    const data = await res.json(); // {id, label?}
    if (typeof onOk === 'function') onOk(data);
  }

  // Organism
  const orgForm = document.getElementById('organism-form');
  if (orgForm) orgForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(orgForm, ({id, label}) => {
      setLink('organism', id, label || id);
      alert('Organism guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Location
  const locForm = document.getElementById('location-form');
  if (locForm) locForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(locForm, ({id, label}) => {
      setLink('location', id, label || id);
      alert('Location guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Taxon
  const taxForm = document.getElementById('taxon-form');
  if (taxForm) taxForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(taxForm, ({id, label}) => {
      setLink('taxon', id, label || id);
      alert('Taxon guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Identification
  const idForm = document.getElementById('identification-form');
  if (idForm) idForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(idForm, ({id, label}) => {
      setLink('identification', id, label || id);
      alert('Identification guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // ====== Aviso al salir si hay cambios ======
  window.addEventListener('beforeunload', function (e) {
    // Si existe cualquiera de los borradores o hicimos cambios
    const anyDraft =
      localStorage.getItem(KEY_OCC) ||
      localStorage.getItem(KEY_RL)  ||
      localStorage.getItem(KEY_ORG) ||
      localStorage.getItem(KEY_LOC) ||
      localStorage.getItem(KEY_TAX) ||
      localStorage.getItem(KEY_ID);
    if (dirty || anyDraft) {
      e.preventDefault();
      e.returnValue = '';
      return '';
    }
  });

  document.getElementById('btn-clear-all')?.addEventListener('click', () => {
    [KEY_OCC,KEY_RL,KEY_ORG,KEY_LOC,KEY_TAX,KEY_ID,KEY_LINKS].forEach(k => localStorage.removeItem(k));
    ['record_level_id','organismID','locationID','taxonID','identificationID'].forEach(id => {
      const el = document.getElementById(id); if (el) el.value = '';
    });
    ['summary-rl','summary-org','summary-loc','summary-tax','summary-id'].forEach(id => {
      const el = document.getElementById(id); if (el) el.textContent = '—';
    });
    
    // Evita el beforeunload y recarga
    dirty = false;                     // <— importante
    window.location.reload();          // <— recarga la página
  });


})();

function unlockBodyScrollIfNoModal() {
    if (!document.querySelector('.modal.show')) {
      document.body.classList.remove('modal-open');
      document.body.style.removeProperty('overflow');
      document.body.style.removeProperty('padding-right');
      document.documentElement.style.removeProperty('overflow');
      document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach(b => b.remove());
    }
  }

  document.addEventListener('hidden.bs.modal', unlockBodyScrollIfNoModal);
  window.unlockBodyScrollIfNoModal = unlockBodyScrollIfNoModal;

</script>

<script>
(function () {
  const IS_EDIT = @json(isset($item) && $item->exists);
  const OCC_ID  = @json(isset($item) ? $item->id_occ_bd : null);
  const KEY_OCC = IS_EDIT ? `occ_wizard_occurrence_v2:${OCC_ID}` : 'occ_wizard_occurrence_v2';

  function safeRestore(draft) {
    for (const [name, val] of Object.entries(draft)) {
      const el = document.querySelector(`[name="${name}"]`);
      if (!el) continue;

      // Si es select, no sobreescribir si ya hay una opción seleccionada distinta de vacío
      if (el.tagName === 'SELECT') {
        const hasSelected = Array.from(el.options).some(o => o.selected && o.value !== '');
        if (hasSelected) continue;
      } else {
        // Para inputs normales, no pises si ya trae valor del servidor
        if (el.value != null && String(el.value).trim() !== '') continue;
      }

      if (val != null && String(val).trim() !== '') el.value = val;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    try {
      const draft = JSON.parse(localStorage.getItem(KEY_OCC) || '{}');
      safeRestore(draft);
    } catch {}
  });
})();
</script>


@endpush

