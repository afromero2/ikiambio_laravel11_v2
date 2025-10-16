@extends('layouts.sidebar')

@section('title','Occurrence — Editar')
@section('page_title','Editar Occurrence')

@php $page = request('page', 1); @endphp

@section('content')
<div class="card card-body">

  @if (session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      {{ __('validation.txtValidacion') }}
    </div>
  @endif

  <form method="POST" action="{{ route('occurrence.update', $item) }}">
    @csrf @method('PUT')
    @include('pages.occurrence.partials.form', [
      'item' => $item ?? null,
      'recordLevels' => $recordLevels,
      'oqtypes' => $oqtypes,
      'sexes' => $sexes,
      'lifeStages' => $lifeStages,
      'reproConds' => $reproConds,
      'estabMeans' => $estabMeans,
      'dispositions' => $dispositions,
      'continents' => $continents,
      'verbatimSrs' => $verbatimSrs,
      'georefStatuses' => $georefStatuses,
    ])
    <div class="mt-3">
      <button class="btn btn-primary">Actualizar</button>
      <a class="btn btn-outline-secondary" href="{{ route('occurrence.index', ['occurrence' => $item->id_occ_bd, 'page' => $page]) }}">Volver</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
(function () {
  // En edición queremos evitar que borradores del wizard contaminen la vista
  const WIZ_KEYS = [
    'occ_wizard_occurrence_v2',
    'occ_wizard_record_level_v2',
    'occ_wizard_organism_v2',
    'occ_wizard_location_v2',
    'occ_wizard_taxon_v2',
    'occ_wizard_identification_v2',
    'occ_wizard_links_v2',
  ];
  const PREFIX = 'occ_wizard_';

  // 1) Borrar borradores conocidos del wizard
  try { WIZ_KEYS.forEach(k => localStorage.removeItem(k)); } catch {}

  // 2) Parche: mientras estés en esta vista, ignora lecturas/escrituras de esas claves
  (function(ls){
    if (!ls) return;
    const get = ls.getItem.bind(ls);
    const set = ls.setItem.bind(ls);
    const rem = ls.removeItem.bind(ls);

    const isWizardKey = k => typeof k === 'string' && k.startsWith(PREFIX);

    ls.getItem = function(k){ return isWizardKey(k) ? null : get(k); };
    ls.setItem = function(k, v){ if (isWizardKey(k)) return; return set(k, v); };
    // removeItem lo dejamos “normal” por si tu UI necesita limpiar algo explícitamente
    ls.removeItem = function(k){ return rem(k); };
  })(window.localStorage);
})();
</script>
@endpush
