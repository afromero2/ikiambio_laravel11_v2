
{{-- @extends('layouts.app') --}}
@extends('layouts.sidebar')
@section('title','Editar usuario')

@section('content')
<h1 class="h4 mb-3">Editar usuario #{{ $user->id }}</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('ikiambio-users.update',$user) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">UtplId</label>
      <input name="utplId" value="{{ old('utplId',$user->utplId) }}" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Identificación</label>
      <input name="identification" value="{{ old('identification',$user->identification) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Nombres *</label>
      <input name="firstName" value="{{ old('firstName',$user->firstName) }}" required class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Apellidos *</label>
      <input name="lastName" value="{{ old('lastName',$user->lastName) }}" required class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Username *</label>
      <input name="username" value="{{ old('username',$user->username) }}" required class="form-control">
    </div>
  </div>

  <div class="mt-3">
    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('ikiambio-users.index') }}" class="btn btn-link">Cancelar</a>
  </div>
</form>
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
