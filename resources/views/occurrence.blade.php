@extends('layouts.sidebar')

@section('title','Ocurrence — IKIAM')
{{-- @section('page_title','Inicio') --}}
@section('page_title')
    <a href="{{ url('/') }}">Inicio</a>
@endsection
@section('content')

{{-- INICIO tabs de tablas principales --}}
{{-- ================== ESTILOS (puedes moverlos a tu app.css si quieres) ================== --}}
<style>
  .tabs { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
  .tabs [role="tablist"]{
    display:flex; gap:8px; border-bottom:1px solid #e5e7eb;
    margin-bottom:8px; overflow-x:auto;
  }
  .tabs [role="tab"]{
    background:#f9fafb; border:1px solid #e5e7eb; border-bottom-color:transparent;
    padding:8px 12px; border-radius:8px 8px 0 0; cursor:pointer;
    color:#374151; font-weight:600; white-space:nowrap;
  }
  .tabs [role="tab"][aria-selected="true"]{ background:#fff; color:#111827; }
  .tabs [role="tabpanel"]{
    border:1px solid #e5e7eb; border-radius:0 12px 12px 12px; padding:16px;
  }

  /* Scroll horizontal propio por tabla */
  .tabs .table-wrap {
    overflow-x: auto;   /* solo horizontal */
    max-width: 100%;
    margin-bottom: 1rem;
  }
  .tabs table{
    width: max-content;   /* ocupa lo necesario según columnas */
    min-width: 100%;      /* al menos el ancho del contenedor */
    border-collapse: collapse;
    font-size: 13px;
  }
  .tabs thead th{
    position: sticky; top: 0; background:#f3f4f6;
    text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;
  }
  .tabs tbody td{ border-bottom:1px solid #f1f5f9; padding:6px 8px; vertical-align:top; }
  .tabs .actions{ display:flex; gap:6px; white-space:nowrap; }
  .tabs .btn{
    border:1px solid #e5e7eb; background:#fff; padding:5px 8px;
    border-radius:8px; cursor:pointer; font-size:12px;
  }
  .tabs .btn:hover{ background:#f9fafb; }
  .tabs .btn.view{ border-color:#60a5fa; }
  .tabs .btn.edit{ border-color:#34d399; }
  .tabs .btn.del{  border-color:#f87171; }

  /* ===== Modal ===== */
  .modal-backdrop{
    position: fixed; inset: 0; background: rgba(0,0,0,.45);
    display: none; align-items: center; justify-content: center; z-index: 1050;
  }
  .modal{
    background: #fff; width: min(900px, 92vw); max-height: 86vh;
    border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.2);
    display: grid; grid-template-rows: auto 1fr auto; overflow: hidden;
  }
  .modal-header{
    padding: 14px 18px; border-bottom: 1px solid #e5e7eb;
    display:flex; align-items:center; justify-content:space-between; gap:8px;
  }
  .modal-title{ font-weight: 800; font-size: 18px; }
  .modal-body{ padding: 14px 18px; overflow: auto; }
  .modal-footer{
    padding: 12px 18px; border-top: 1px solid #e5e7eb;
    display:flex; justify-content:flex-end; gap:8px;
  }
  .modal .form-grid{
    display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap:12px;
  }
  .modal .form-grid .field{ display:flex; flex-direction:column; gap:6px; }
  .modal .form-grid label{ font-size:12px; color:#6b7280; }
  .modal .form-grid input, .modal .form-grid textarea{
    border: 1px solid #e5e7eb; border-radius: 10px;
    padding:8px 10px; font-size:13px; width:100%;
  }
  .modal .form-grid textarea{ min-height: 80px; resize: vertical; }
  .btn.primary{ background:#111827; color:#fff; border-color:#111827; }
  .btn.danger{ border-color:#ef4444; color:#ef4444; }
  .btn.ghost{ background:transparent; }
  .tag{
    font-size:12px; padding:2px 8px; border-radius:999px;
    border:1px solid #e5e7eb; background:#f9fafb;
  }
</style>

{{-- ================== HTML: TABS + TABLAS ================== --}}
<div class="tabs" id="ikiam-tabs">
  <div role="tablist" aria-label="Tablas principales IKIAMBIODB">
    <button role="tab" aria-selected="true"  aria-controls="panel-record_level" id="tab-record_level" tabindex="0">record_level</button>
    <button role="tab" aria-selected="false" aria-controls="panel-event"        id="tab-event"        tabindex="-1">event</button>
    <button role="tab" aria-selected="false" aria-controls="panel-location"     id="tab-location"     tabindex="-1">location</button>
    <button role="tab" aria-selected="false" aria-controls="panel-taxon"        id="tab-taxon"        tabindex="-1">taxon</button>
    <button role="tab" aria-selected="false" aria-controls="panel-occurrence"   id="tab-occurrence"   tabindex="-1">occurrence</button>
    <button role="tab" aria-selected="false" aria-controls="panel-organism"     id="tab-organism"     tabindex="-1">organism</button>
    <button role="tab" aria-selected="false" aria-controls="panel-materialsample" id="tab-materialsample" tabindex="-1">materialSample</button>
    <button role="tab" aria-selected="false" aria-controls="panel-measurementorfacts" id="tab-measurementorfacts" tabindex="-1">measurementOrFacts</button>
  </div>

  <section id="panel-record_level" role="tabpanel" tabindex="0" aria-labelledby="tab-record_level">
    <div class="table-wrap"><table id="tbl-record_level"></table></div>
  </section>
  <section id="panel-event" role="tabpanel" tabindex="0" aria-labelledby="tab-event" hidden>
    <div class="table-wrap"><table id="tbl-event"></table></div>
  </section>
  <section id="panel-location" role="tabpanel" tabindex="0" aria-labelledby="tab-location" hidden>
    <div class="table-wrap"><table id="tbl-location"></table></div>
  </section>
  <section id="panel-taxon" role="tabpanel" tabindex="0" aria-labelledby="tab-taxon" hidden>
    <div class="table-wrap"><table id="tbl-taxon"></table></div>
  </section>
  <section id="panel-occurrence" role="tabpanel" tabindex="0" aria-labelledby="tab-occurrence" hidden>
    <div class="table-wrap"><table id="tbl-occurrence"></table></div>
  </section>
  <section id="panel-organism" role="tabpanel" tabindex="0" aria-labelledby="tab-organism" hidden>
    <div class="table-wrap"><table id="tbl-organism"></table></div>
  </section>
  <section id="panel-materialsample" role="tabpanel" tabindex="0" aria-labelledby="tab-materialsample" hidden>
    <div class="table-wrap"><table id="tbl-materialsample"></table></div>
  </section>
  <section id="panel-measurementorfacts" role="tabpanel" tabindex="0" aria-labelledby="tab-measurementorfacts" hidden>
    <div class="table-wrap"><table id="tbl-measurementorfacts"></table></div>
  </section>
</div>

{{-- ================== HTML: MODAL ================== --}}
<div class="modal-backdrop" id="modal-backdrop" aria-hidden="true">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-header">
      <div>
        <div class="modal-title" id="modal-title">Acción</div>
        <div id="modal-subtitle" style="margin-top:4px; color:#6b7280; font-size:12px;"></div>
      </div>
      <button class="btn ghost" id="modal-close" aria-label="Cerrar">✕</button>
    </div>
    <div class="modal-body">
      <div id="delete-warning" style="display:none; margin-bottom:12px;">
        <span class="tag" style="border-color:#fecaca; background:#fef2f2; color:#991b1b;">Eliminar</span>
        <span style="margin-left:6px; color:#991b1b; font-size:14px;">Esta acción es simulada. ¿Deseas continuar?</span>
      </div>
      <form id="modal-form">
        <div class="form-grid" id="form-grid"></div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn" id="modal-cancel">Cancelar</button>
      <button class="btn danger" id="modal-delete" style="display:none;">Eliminar (simulado)</button>
      <button class="btn primary" id="modal-save" style="display:none;">Guardar (simulado)</button>
    </div>
  </div>
</div>

{{-- ================== SCRIPTS ================== --}}
<script>
/* === 1) Columnas por tabla (ajusta si tu SQL usa otros nombres) === */
const columnsByTable = {
  record_level: [
    "recordLevelID","type","language","license","rightsHolder","accessRights",
    "bibliographicCitation","references","informationWithheld","dataGeneralizations",
    "modified","source","datasetID","datasetName","institutionCode","collectionCode",
    "institutionID","collectionID","ownerInstitutionCode","rights","licenseURI","remarks"
  ],
  event: [
    "eventID","parentEventID","samplingProtocol","sampleSizeValue","sampleSizeUnit",
    "samplingEffort","eventDate","eventTime","startDayOfYear","endDayOfYear","year","month","day",
    "verbatimEventDate","fieldNumber","fieldNotes","habitat","eventRemarks"
  ],
  location: [
    "locationID","higherGeographyID","higherGeography","continent","waterBody",
    "islandGroup","island","country","countryCode","stateProvince","county","municipality",
    "locality","verbatimLocality",
    "minimumElevationInMeters","maximumElevationInMeters","verbatimElevation",
    "minimumDepthInMeters","maximumDepthInMeters","verbatimDepth",
    "minimumDistanceAboveSurfaceInMeters","maximumDistanceAboveSurfaceInMeters",
    "decimalLatitude","decimalLongitude","geodeticDatum","coordinateUncertaintyInMeters",
    "coordinatePrecision","pointRadiusSpatialFit","verbatimCoordinates","verbatimLatitude",
    "verbatimLongitude","verbatimCoordinateSystem","verbatimSRS",
    "footprintWKT","footprintSRS","footprintSpatialFit",
    "georeferencedBy","georeferencedDate","georeferenceProtocol","georeferenceSources",
    "georeferenceVerificationStatus","georeferenceRemarks","locationAccordingTo","locationRemarks"
  ],
  taxon: [
    "taxonID","scientificNameID","acceptedNameUsageID","parentNameUsageID","originalNameUsageID",
    "nameAccordingToID","namePublishedInID","taxonConceptID",
    "scientificName","acceptedNameUsage","parentNameUsage","originalNameUsage",
    "nameAccordingTo","namePublishedIn","namePublishedInYear","higherClassification",
    "kingdom","phylum","class","order","family","genus","subgenus",
    "specificEpithet","infraspecificEpithet","taxonRank","verbatimTaxonRank",
    "scientificNameAuthorship","vernacularName","nomenclaturalCode",
    "taxonomicStatus","nomenclaturalStatus","taxonRemarks"
  ],
  occurrence: [
    "occurrenceID","organismID","eventID","locationID","taxonID",
    "catalogNumber","recordNumber","recordedBy","recordedByID",
    "individualCount","organismQuantity","organismQuantityType",
    "sex","lifeStage","reproductiveCondition","behavior",
    "establishmentMeans","degreeOfEstablishment","pathway",
    "occurrenceStatus","preparations","disposition",
    "associatedMedia","associatedReferences","associatedOccurrences","associatedSequences","associatedTaxa",
    "otherCatalogNumbers","occurrenceRemarks"
  ],
  organism: [
    "organismID","organismName","organismScope","associatedOccurrences","associatedOrganisms",
    "previousIdentifications","organismQuantity","organismQuantityType",
    "sex","lifeStage","reproductiveCondition","behavior","establishmentMeans",
    "organismRemarks"
  ],
  materialsample: [
    "materialSampleID","parentMaterialSampleID","materialSampleName","materialSampleType",
    "associatedOccurrences","associatedSamples","sampleStorageLocation",
    "preparations","disposition","organismID","eventID","materialSampleRemarks"
  ],
  measurementorfacts: [
    "measurementID","occurrenceID","measurementType","measurementValue",
    "measurementAccuracy","measurementUnit","measurementDeterminedDate",
    "measurementDeterminedBy","measurementMethod","measurementRemarks"
  ]
};

/* === 2) Datos ficticios por fila === */
function fakeRow(tableName, idx){
  const now = new Date();
  const d = (shift)=> new Date(now.getTime() - shift*86400000).toISOString().slice(0,10);
  const rand = (a,b)=> Math.floor(Math.random()*(b-a+1))+a;
  const id = (p)=> `${p}-${String(idx).padStart(4,'0')}`;

  const base = {
    record_level: {
      recordLevelID: id("RL"), type: ["StillImage","MovingImage","Sound","PhysicalObject","Event"][idx%5],
      language: ["es","en"][idx%2], license: ["CC-BY","CC0","CC-BY-SA"][idx%3],
      rightsHolder: ["IKIAM","Laboratorio BI","Proyecto HerpAmazon"][idx%3],
      accessRights: "open", bibliographicCitation: `Cita ${idx}`, references: `http://ref.example/${idx}`,
      informationWithheld: "", dataGeneralizations: "", modified: d(5+idx),
      source: "IKIAMBIODB", datasetID: id("DS"), datasetName: ["HerpAmazon","IctioSur","MacroInv 2025"][idx%3],
      institutionCode: "IKIAM", collectionCode: ["HERP","ICTIO","MACRO"][idx%3],
      institutionID: "IKIAM-001", collectionID: ["COL-01","COL-02","COL-03"][idx%3],
      ownerInstitutionCode: "IKIAM", rights: "Some rights reserved",
      licenseURI: "https://creativecommons.org/licenses/by/4.0/", remarks: `Registro ${idx}`
    },
    event: {
      eventID: id("EV"), parentEventID: "", samplingProtocol: ["VisualEncounter","Pitfall","Netting"][idx%3],
      sampleSizeValue: rand(1,10), sampleSizeUnit: ["m","m2","h"][idx%3], samplingEffort: `${rand(1,8)} h`,
      eventDate: d(10+idx), eventTime: `${String(8+idx%10).padStart(2,"0")}:00`,
      startDayOfYear: 100+idx, endDayOfYear: 100+idx, year: 2025, month: 7, day: (10+idx),
      verbatimEventDate: d(10+idx), fieldNumber: `F-${rand(1,99)}`, fieldNotes: "Notas de campo",
      habitat: ["Bosque húmedo","Ribera","Matorral"][idx%3], eventRemarks: "Sin novedad"
    },
    location: {
      locationID: id("LC"), higherGeographyID:"HG-ECU", higherGeography:"South America | Ecuador",
      continent:"South America", waterBody:"Amazon Basin", islandGroup:"", island:"",
      country:"Ecuador", countryCode:"EC", stateProvince:["Napo","Pastaza","Orellana"][idx%3],
      county:"-", municipality:["Tena","Puyo","Coca"][idx%3], locality:["Misahuallí","Reserva X","Sendero Y"][idx%3],
      verbatimLocality:"verbatim loc.",
      minimumElevationInMeters: 250, maximumElevationInMeters: 420, verbatimElevation:"250–420 m",
      minimumDepthInMeters:"", maximumDepthInMeters:"", verbatimDepth:"",
      minimumDistanceAboveSurfaceInMeters:"", maximumDistanceAboveSurfaceInMeters:"",
      decimalLatitude: (-1.0 - idx*0.01).toFixed(6), decimalLongitude: (-77.8 - idx*0.01).toFixed(6),
      geodeticDatum:"WGS84", coordinateUncertaintyInMeters: 30, coordinatePrecision: 0.0001,
      pointRadiusSpatialFit:"", verbatimCoordinates:"", verbatimLatitude:"", verbatimLongitude:"",
      verbatimCoordinateSystem:"", verbatimSRS:"",
      footprintWKT:"", footprintSRS:"EPSG:4326", footprintSpatialFit:"",
      georeferencedBy:"Equipo SIG", georeferencedDate:d(8+idx), georeferenceProtocol:"GPS",
      georeferenceSources:"Base local", georeferenceVerificationStatus:"verified",
      georeferenceRemarks:"ok", locationAccordingTo:"Proyecto IKIAM", locationRemarks:""
    },
    taxon: {
      taxonID: id("TX"), scientificNameID:`SN-${idx}`, acceptedNameUsageID:"", parentNameUsageID:"",
      originalNameUsageID:"", nameAccordingToID:"", namePublishedInID:"",
      taxonConceptID:"", scientificName:["Rhinella marina","Hypsiboas punctatus","Characidium sp."][idx%3],
      acceptedNameUsage:"", parentNameUsage:"", originalNameUsage:"",
      nameAccordingTo:"Catalogue of Life", namePublishedIn:"Zootaxa", namePublishedInYear: 2015,
      higherClassification:"Animalia | Chordata | Amphibia", kingdom:"Animalia", phylum:"Chordata",
      class:"Amphibia", order:"Anura", family:["Bufonidae","Hylidae","Crenuchidae"][idx%3],
      genus:["Rhinella","Hypsiboas","Characidium"][idx%3], subgenus:"",
      specificEpithet:["marina","punctatus","sp."][idx%3], infraspecificEpithet:"",
      taxonRank:"species", verbatimTaxonRank:"species",
      scientificNameAuthorship:"(Linnaeus, 1758)", vernacularName:"Sapo/Rana",
      nomenclaturalCode:"ICZN", taxonomicStatus:"accepted", nomenclaturalStatus:"",
      taxonRemarks:"—"
    },
    occurrence: {
      occurrenceID: id("OC"), organismID: id("OR"), eventID: id("EV"), locationID: id("LC"), taxonID: id("TX"),
      catalogNumber:`CAT-${idx}`, recordNumber:`REC-${idx}`, recordedBy:["M. Vivanco","E. Rojas","L. Sánchez"][idx%3],
      recordedByID:"", individualCount: rand(1,5), organismQuantity: rand(1,5), organismQuantityType:"count",
      sex:["male","female","unknown"][idx%3], lifeStage:["adult","juvenile","larva"][idx%3],
      reproductiveCondition:"", behavior:["calling","foraging","resting"][idx%3],
      establishmentMeans:"native", degreeOfEstablishment:"established", pathway:"",
      occurrenceStatus:"present", preparations:"photo", disposition:"in collection",
      associatedMedia:"http://media.example/x.jpg", associatedReferences:"http://doi.example/xx",
      associatedOccurrences:"", associatedSequences:"", associatedTaxa:"",
      otherCatalogNumbers:"-", occurrenceRemarks:"Observado a orilla de río"
    },
    organism: {
      organismID: id("OR"), organismName:`Ejemplar ${idx}`, organismScope:"individual",
      associatedOccurrences:id("OC"), associatedOrganisms:"", previousIdentifications:"",
      organismQuantity:1, organismQuantityType:"count",
      sex:["male","female","unknown"][idx%3], lifeStage:["adult","juvenile","larva"][idx%3],
      reproductiveCondition:"", behavior:"calm", establishmentMeans:"native",
      organismRemarks:"PIT tag"
    },
    materialsample: {
      materialSampleID: id("MS"), parentMaterialSampleID:"", materialSampleName:`Muestra ${idx}`,
      materialSampleType:["tissue","blood","voucher"][idx%3], associatedOccurrences:id("OC"),
      associatedSamples:"", sampleStorageLocation:"Freezer -20°C", preparations:"ethanol",
      disposition:"in collection", organismID:id("OR"), eventID:id("EV"), materialSampleRemarks:"—"
    },
    measurementorfacts: {
      measurementID: id("ME"), occurrenceID: id("OC"), measurementType:["SVL","Mass","TL"][idx%3],
      measurementValue:[42.1, 15.3, 58.7][idx%3], measurementAccuracy:0.1, measurementUnit:["mm","g","mm"][idx%3],
      measurementDeterminedDate: d(3+idx), measurementDeterminedBy:["M. Vivanco","E. Rojas","L. Sánchez"][idx%3],
      measurementMethod:"vernier", measurementRemarks:"—"
    }
  };
  return base[tableName];
}

/* === 3) Render de tablas === */
function renderTable(tableId, tableName, rowsCount=3){
  const table = document.getElementById(tableId);
  const cols = columnsByTable[tableName];

  const thead = document.createElement("thead");
  const trh = document.createElement("tr");
  cols.forEach(c=>{
    const th = document.createElement("th");
    th.textContent = c;
    trh.appendChild(th);
  });
  const thAct = document.createElement("th");
  thAct.textContent = "actions";
  trh.appendChild(thAct);
  thead.appendChild(trh);

  const tbody = document.createElement("tbody");
  for(let i=1;i<=rowsCount;i++){
    const data = fakeRow(tableName, i);
    const tr = document.createElement("tr");
    cols.forEach(c=>{
      const td = document.createElement("td");
      td.textContent = (data && data[c] !== undefined) ? data[c] : "—";
      tr.appendChild(td);
    });
    const tdAct = document.createElement("td");
    tdAct.className = "actions";
    const idValue = Object.values(data)[0] || "";
    tdAct.innerHTML = `
      <button class="btn view" data-action="view" data-table="${tableName}" data-id="${idValue}">Ver</button>
      <button class="btn edit" data-action="edit" data-table="${tableName}" data-id="${idValue}">Editar</button>
      <button class="btn del"  data-action="delete" data-table="${tableName}" data-id="${idValue}"><i class="fa fa-trash"></i></button>`;
    tr.appendChild(tdAct);
    tbody.appendChild(tr);
  }

  table.innerHTML = "";
  table.appendChild(thead);
  table.appendChild(tbody);
}

/* === 4) Inicialización === */
renderTable("tbl-record_level","record_level", 3);
renderTable("tbl-event","event", 3);
renderTable("tbl-location","location", 3);
renderTable("tbl-taxon","taxon", 3);
renderTable("tbl-occurrence","occurrence", 3);
renderTable("tbl-organism","organism", 3);
renderTable("tbl-materialsample","materialsample", 3);
renderTable("tbl-measurementorfacts","measurementorfacts", 3);

/* === 5) Tabs accesibles === */
const container = document.getElementById("ikiam-tabs");
const tablist = container.querySelector('[role="tablist"]');
const tabs = Array.from(container.querySelectorAll('[role="tab"]'));
const panels = Array.from(container.querySelectorAll('[role="tabpanel"]'));

function activateTab(tab) {
  tabs.forEach(t => {
    const selected = t === tab;
    t.setAttribute('aria-selected', selected ? 'true' : 'false');
    t.tabIndex = selected ? 0 : -1;
  });
  panels.forEach(p => {
    const show = p.id === tab.getAttribute('aria-controls');
    if (show) p.removeAttribute('hidden'); else p.setAttribute('hidden', '');
  });
  tab.focus();
}
tabs.forEach(t => t.addEventListener('click', () => activateTab(t)));
tablist.addEventListener('keydown', e => {
  const i = tabs.indexOf(document.activeElement);
  if (i === -1) return;
  let nextIndex = i;
  if (e.key === 'ArrowRight') nextIndex = (i + 1) % tabs.length;
  else if (e.key === 'ArrowLeft') nextIndex = (i - 1 + tabs.length) % tabs.length;
  else if (e.key === 'Home') nextIndex = 0;
  else if (e.key === 'End') nextIndex = tabs.length - 1;
  else return;
  e.preventDefault();
  activateTab(tabs[nextIndex]);
});

/* === 6) Utilidades: pasar fila a objeto === */
function getRowDataFromClick(target){
  const tr = target.closest('tr');
  const table = target.closest('table');
  const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent);
  const values = Array.from(tr.querySelectorAll('td'));
  const obj = {};
  headers.forEach((h, idx) => {
    if(h === 'actions') return;
    obj[h] = values[idx]?.textContent ?? '';
  });
  return obj;
}

/* === 7) Modal: abrir, poblar y acciones (simuladas) === */
const backdrop = document.getElementById('modal-backdrop');
const titleEl = document.getElementById('modal-title');
const subtitleEl = document.getElementById('modal-subtitle');
const formGrid = document.getElementById('form-grid');
const formEl = document.getElementById('modal-form');
const deleteWarn = document.getElementById('delete-warning');
const btnSave = document.getElementById('modal-save');
const btnDelete = document.getElementById('modal-delete');
const btnCancel = document.getElementById('modal-cancel');
const btnClose = document.getElementById('modal-close');

function openModal({action, tableName, rowData}){
  const idShown = Object.values(rowData)[0] || '—';
  titleEl.textContent = (action === 'view' ? 'Ver' : action === 'edit' ? 'Editar' : 'Eliminar') + ` → ${tableName}`;
  subtitleEl.textContent = `ID: ${idShown}`;

  deleteWarn.style.display = action === 'delete' ? '' : 'none';
  btnDelete.style.display = action === 'delete' ? '' : 'none';
  btnSave.style.display   = action === 'edit'   ? '' : 'none';

  formGrid.innerHTML = '';
  Object.entries(rowData).forEach(([key, val]) => {
    const field = document.createElement('div');
    field.className = 'field';
    const label = document.createElement('label');
    label.textContent = key;
    let control;
    if(String(val).length > 60){
      control = document.createElement('textarea');
      control.value = val;
    }else{
      control = document.createElement('input');
      control.type = 'text';
      control.value = val;
    }
    control.name = key;
    control.readOnly = (action === 'view' || action === 'delete');
    field.appendChild(label);
    field.appendChild(control);
    formGrid.appendChild(field);
  });

  backdrop.style.display = 'flex';

  btnSave.onclick = () => {
    const formData = Object.fromEntries(new FormData(formEl).entries());
    alert('Guardar (simulado)\\n' + JSON.stringify(formData, null, 2));
    closeModal();
  };
  btnDelete.onclick = () => {
    alert('Eliminar (simulado)\\n' + JSON.stringify({ tableName, id: idShown }, null, 2));
    closeModal();
  };
}
function closeModal(){ backdrop.style.display = 'none'; }
btnCancel.addEventListener('click', closeModal);
btnClose.addEventListener('click', closeModal);
backdrop.addEventListener('click', (e)=>{ if(e.target === backdrop) closeModal(); });
document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape' && backdrop.style.display === 'flex') closeModal(); });

/* === 8) Delegación: botones de tabla abren el modal === */
document.addEventListener('click', (e) => {
  const btn = e.target.closest('.btn');
  if(!btn) return;
  const action = btn.dataset.action;
  if(!['view','edit','delete'].includes(action)) return;

  const tableName = btn.dataset.table;
  const rowData = getRowDataFromClick(btn);
  openModal({action, tableName, rowData});
});
</script>

{{-- Fin tabs de tablas principales --}}
<!-- INICIO FORMULARIO OCCURRENCE -->
<!-- ======= FORMULARIO OCCURRENCE (Responsive, alineado a la izquierda) ======= -->
<style>
  .occ-wrapper{
    width:100%;
    max-width:1000px;  /* límite superior del formulario */
    margin:0;          /* 👈 pegado a la izquierda, sin centrado */
  }
  .occ-card{
    font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;
    border:1px solid #e5e7eb; border-radius:12px;
  }
  .occ-head{ padding:14px 16px; border-bottom:1px solid #e5e7eb; font-weight:800; }
  .occ-body{ padding:16px; }
  .occ-grid{
    display:grid;
    grid-template-columns:repeat(3, minmax(0,1fr)); /* 3 columnas por defecto */
    gap:12px;
  }
  .occ-field{ display:flex; flex-direction:column; gap:6px; }
  .occ-field label{ font-size:12px; color:#6b7280; }
  .occ-field input, .occ-field select, .occ-field textarea{
    border:1px solid #e5e7eb; border-radius:10px; padding:8px 10px; font-size:13px; width:100%;
  }
  .occ-field textarea{ min-height:90px; resize:vertical; }  /* 👈 igual ancho que inputs */
  .occ-actions{
    display:flex; gap:8px; justify-content:flex-start;  /* 👈 acciones a la izquierda */
    padding:12px 16px; border-top:1px solid #e5e7eb;
  }
  .btn{ border:1px solid #e5e7eb; background:#fff; padding:8px 12px; border-radius:10px; cursor:pointer; }
  .btn.primary{ background:#111827; color:#fff; border-color:#111827; }
  .occ-section{ grid-column:1 / -1; margin-top:8px; font-weight:700; color:#374151; }
  .muted{ font-size:12px; color:#6b7280; }

  /* Breakpoints: 3 → 2 → 1 columnas */
  @media (max-width: 1100px){ .occ-grid{ grid-template-columns:repeat(2, minmax(0,1fr)); } }
  @media (max-width: 720px){  .occ-grid{ grid-template-columns:1fr; } }
</style>

 <div class="occ-wrapper">
  <form class="occ-card" action="#" method="post">
    <div class="occ-head">Occurrence (Demo adaptable, izquierda)</div>
    <div class="occ-body">
      <div class="occ-grid">

        <!-- ================= Identificadores ================= -->
        <div class="occ-section">Identificadores</div>
        <div class="occ-field"><label for="occurrenceID">Occurrence ID</label><input type="text" id="occurrenceID" name="occurrenceID" value="OC-0001"></div>
        <div class="occ-field"><label for="organismID">Organism ID</label><input type="text" id="organismID" name="organismID" value="OR-0010"></div>
        <div class="occ-field"><label for="eventID">Event ID</label><input type="text" id="eventID" name="eventID" value="EV-2025"></div>
        <div class="occ-field"><label for="locationID">Location ID</label><input type="text" id="locationID" name="locationID" value="LC-0789"></div>
        <div class="occ-field"><label for="taxonID">Taxon ID</label><input type="text" id="taxonID" name="taxonID" value="TX-0456"></div>
        <div class="occ-field"><label for="catalogNumber">Catalog Number</label><input type="text" id="catalogNumber" name="catalogNumber" value="CAT-2025-001"></div>
        <div class="occ-field"><label for="recordNumber">Record Number</label><input type="text" id="recordNumber" name="recordNumber" value="REC-2025-01"></div>
        <div class="occ-field"><label for="recordedBy">Recorded By</label><input type="text" id="recordedBy" name="recordedBy" value="Marco Xavier Rojas Vivanco"></div>
        <div class="occ-field"><label for="recordedByID">Recorded By ID</label><input type="text" id="recordedByID" name="recordedByID" value="mxrv-001"></div>

        <!-- ================= Conteos ================= -->
        <div class="occ-section">Conteos</div>
        <div class="occ-field"><label for="individualCount">Individual Count</label><input type="number" id="individualCount" name="individualCount" value="3" min="0"></div>
        <div class="occ-field"><label for="organismQuantity">Organism Quantity</label><input type="number" id="organismQuantity" name="organismQuantity" value="3" min="0"></div>
        <div class="occ-field"><label for="organismQuantityType">Organism Quantity Type</label><input type="text" id="organismQuantityType" name="organismQuantityType" value="count"></div>

        <!-- ================= Vocabularios controlados (SELECT) ================= -->
        <div class="occ-section">Vocabularios controlados</div>
        <div class="occ-field"><label for="sex">Sex</label>
          <select id="sex" name="sex">
            <option value="">-- Seleccione --</option>
            <option value="male" selected>Macho</option>
            <option value="female">Hembra</option>
            <option value="hermaphrodite">Hermafrodita</option>
            <option value="unknown">Desconocido</option>
          </select>
        </div>
        <div class="occ-field"><label for="lifeStage">Life Stage</label>
          <select id="lifeStage" name="lifeStage">
            <option value="">-- Seleccione --</option>
            <option value="egg">Huevo</option>
            <option value="larva">Larva</option>
            <option value="juvenile">Juvenil</option>
            <option value="subadult">Subadulto</option>
            <option value="adult" selected>Adulto</option>
          </select>
        </div>
        <div class="occ-field"><label for="reproductiveCondition">Reproductive Condition</label>
          <select id="reproductiveCondition" name="reproductiveCondition">
            <option value="">-- Seleccione --</option>
            <option value="reproductive" selected>Reproductiva</option>
            <option value="non-reproductive">No reproductiva</option>
            <option value="gravid">Grávida</option>
            <option value="breeding">En reproducción</option>
          </select>
        </div>
        <div class="occ-field"><label for="behavior">Behavior</label>
          <select id="behavior" name="behavior">
            <option value="">-- Seleccione --</option>
            <option value="calling" selected>Llamando</option>
            <option value="foraging">Forrajeando</option>
            <option value="resting">En reposo</option>
            <option value="basking">Asolado</option>
            <option value="mating">Apareándose</option>
          </select>
        </div>
        <div class="occ-field"><label for="establishmentMeans">Establishment Means</label>
          <select id="establishmentMeans" name="establishmentMeans">
            <option value="">-- Seleccione --</option>
            <option value="native" selected>Nativo</option>
            <option value="introduced">Introducido</option>
            <option value="invasive">Invasivo</option>
            <option value="managed">Manejado</option>
            <option value="uncertain">Incierto</option>
          </select>
        </div>
        <div class="occ-field"><label for="degreeOfEstablishment">Degree of Establishment</label>
          <select id="degreeOfEstablishment" name="degreeOfEstablishment">
            <option value="">-- Seleccione --</option>
            <option value="casual">Casual</option>
            <option value="established" selected>Establecido</option>
            <option value="invasive">Invasivo</option>
            <option value="colonising">Colonizando</option>
            <option value="widespread">Amplia distribución</option>
          </select>
        </div>
        <div class="occ-field"><label for="pathway">Pathway</label>
          <select id="pathway" name="pathway">
            <option value="">-- Seleccione --</option>
            <option value="transport" selected>Transporte (stowaway)</option>
            <option value="escape">Escape de confinamiento</option>
            <option value="release">Liberación en naturaleza</option>
            <option value="corridor">Corredor</option>
            <option value="unaided">No asistido</option>
          </select>
        </div>
        <div class="occ-field"><label for="occurrenceStatus">Occurrence Status</label>
          <select id="occurrenceStatus" name="occurrenceStatus">
            <option value="">-- Seleccione --</option>
            <option value="present" selected>Presente</option>
            <option value="absent">Ausente</option>
          </select>
        </div>
        <div class="occ-field"><label for="preparations">Preparations</label>
          <select id="preparations" name="preparations">
            <option value="">-- Seleccione --</option>
            <option value="photo" selected>Fotografía</option>
            <option value="voucher">Voucher</option>
            <option value="tissue">Tejido</option>
            <option value="audio">Audio</option>
            <option value="video">Video</option>
          </select>
        </div>
        <div class="occ-field"><label for="disposition">Disposition</label>
          <select id="disposition" name="disposition">
            <option value="">-- Seleccione --</option>
            <option value="in collection" selected>En colección</option>
            <option value="missing">Perdido</option>
            <option value="disposed">Eliminado</option>
            <option value="unknown">Desconocido</option>
          </select>
        </div>

        <!-- ================= Asociados / Referencias ================= -->
        <div class="occ-section">Asociados / Referencias</div>
        <div class="occ-field"><label for="associatedMedia">Associated Media (URL)</label><input type="url" id="associatedMedia" name="associatedMedia" value="https://example.org/media/oc-0001.jpg"></div>
        <div class="occ-field"><label for="associatedReferences">Associated References (URL/DOI)</label><input type="text" id="associatedReferences" name="associatedReferences" value="https://doi.org/10.1234/demo.2025.001"></div>
        <div class="occ-field"><label for="associatedOccurrences">Associated Occurrences</label><input type="text" id="associatedOccurrences" name="associatedOccurrences" value="OC-0002, OC-0003"></div>
        <div class="occ-field"><label for="associatedSequences">Associated Sequences</label><input type="text" id="associatedSequences" name="associatedSequences" value="GenBank:AB123456"></div>
        <div class="occ-field"><label for="associatedTaxa">Associated Taxa</label><input type="text" id="associatedTaxa" name="associatedTaxa" value="Rhinella marina"></div>
        <div class="occ-field"><label for="otherCatalogNumbers">Other Catalog Numbers</label><input type="text" id="otherCatalogNumbers" name="otherCatalogNumbers" value="A-19, B-883"></div>

        <!-- ================= Observaciones ================= -->
        <div class="occ-section">Observaciones</div>
        <div class="occ-field"><label for="occurrenceRemarks">Occurrence Remarks</label>
          <textarea id="occurrenceRemarks" name="occurrenceRemarks">Observado en ribera de río durante muestreo nocturno; clima húmedo, actividad de canto alta.</textarea>
        </div>

      </div>
    </div>
    <div class="occ-actions">
      <button type="reset" class="btn">Limpiar</button>
      <button type="button" class="btn primary">Guardar (simulado)</button>
    </div>
  </form>
</div>
<!-- ======= /FORMULARIO OCCURRENCE ======= -->
<!-- FIN FORMULARIO OCCURRENCE -->

@endsection
