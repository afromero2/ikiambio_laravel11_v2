@extends('layouts.sidebar')
@section('page_title','Nuevo — Tblprimersr')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Tblprimersr</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('tbl-primers-r.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Genabrev</label>
      <input type="text" name="genAbrev" value="{{ old('genAbrev', isset($item)? $item->genAbrev : '') }}" class="input">
    </div>

    <div>
      <label class="label">Genname</label>
      <input type="text" name="genName" value="{{ old('genName', isset($item)? $item->genName : '') }}" class="input">
    </div>

    <div>
      <label class="label">Primername</label>
      <input type="text" name="primerName" value="{{ old('primerName', isset($item)? $item->primerName : '') }}" class="input">
    </div>

    <div>
      <label class="label">Primersequence</label>
      <textarea name="primerSequence" class="input" rows="3">{{ old('primerSequence', isset($item)? $item->primerSequence : '') }}</textarea>
    </div>

    <div>
      <label class="label">Primerreferencecitation</label>
      <textarea name="primerReferenceCitation" class="input" rows="3">{{ old('primerReferenceCitation', isset($item)? $item->primerReferenceCitation : '') }}</textarea>
    </div>

    <div>
      <label class="label">Id primerdirection</label>
      <input type="number" name="id_primerDirection" value="{{ old('id_primerDirection', isset($item)? $item->id_primerDirection : '') }}" class="input">
    </div>

    <div>
      <label class="label">Grupo taxonomico</label>
      <input type="text" name="grupo_Taxonomico" value="{{ old('grupo_Taxonomico', isset($item)? $item->grupo_Taxonomico : '') }}" class="input">
    </div>

    <div>
      <label class="label">Region</label>
      <input type="text" name="region" value="{{ old('region', isset($item)? $item->region : '') }}" class="input">
    </div>

    <div>
      <label class="label">Tecnologia</label>
      <input type="text" name="tecnologia" value="{{ old('tecnologia', isset($item)? $item->tecnologia : '') }}" class="input">
    </div>

    <div>
      <label class="label">Proyecto tesis</label>
      <input type="text" name="proyecto_Tesis" value="{{ old('proyecto_Tesis', isset($item)? $item->proyecto_Tesis : '') }}" class="input">
    </div>

    <div>
      <label class="label">Longitud primer</label>
      <input type="number" name="longitud_Primer" value="{{ old('longitud_Primer', isset($item)? $item->longitud_Primer : '') }}" class="input">
    </div>

    <div>
      <label class="label">Longitud amplicon</label>
      <input type="number" name="Longitud_amplicon" value="{{ old('Longitud_amplicon', isset($item)? $item->Longitud_amplicon : '') }}" class="input">
    </div>

    <div>
      <label class="label">Gc</label>
      <input type="number" name="gc" value="{{ old('gc', isset($item)? $item->gc : '') }}" class="input">
    </div>

    <div>
      <label class="label">Dnameltingpoint</label>
      <input type="number" name="dnaMeltingPoint" value="{{ old('dnaMeltingPoint', isset($item)? $item->dnaMeltingPoint : '') }}" class="input">
    </div>

    <div>
      <label class="label">Annealing temperature</label>
      <input type="number" name="annealing_Temperature" value="{{ old('annealing_Temperature', isset($item)? $item->annealing_Temperature : '') }}" class="input">
    </div>

    <div>
      <label class="label">Primerstaff</label>
      <input type="text" name="primerStaff" value="{{ old('primerStaff', isset($item)? $item->primerStaff : '') }}" class="input">
    </div>

    <div>
      <label class="label">Fecha orden</label>
      <input type="date" name="fecha_orden" value="{{ old('fecha_orden', isset($item)? $item->fecha_orden : '') }}" class="input">
    </div>

    <div>
      <label class="label">Proveedor</label>
      <input type="text" name="proveedor" value="{{ old('proveedor', isset($item)? $item->proveedor : '') }}" class="input">
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('tbl-primers-r.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
