@extends('layouts.sidebar')
@section('page_title','Detalle — Tblprimersf')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Tblprimersf #{ $item->idPrimers }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Idprimers</dt>
      <dd class="col-sm-8">{{ $item->idPrimers }}</dd>
      <dt class="col-sm-4">Genabrev</dt>
      <dd class="col-sm-8">{{ $item->genAbrev }}</dd>
      <dt class="col-sm-4">Genname</dt>
      <dd class="col-sm-8">{{ $item->genName }}</dd>
      <dt class="col-sm-4">Primername</dt>
      <dd class="col-sm-8">{{ $item->primerName }}</dd>
      <dt class="col-sm-4">Primersequence</dt>
      <dd class="col-sm-8">{{ $item->primerSequence }}</dd>
      <dt class="col-sm-4">Primerreferencecitation</dt>
      <dd class="col-sm-8">{{ $item->primerReferenceCitation }}</dd>
      <dt class="col-sm-4">Id primerdirection</dt>
      <dd class="col-sm-8">{{ $item->id_primerDirection }}</dd>
      <dt class="col-sm-4">Grupo taxonomico</dt>
      <dd class="col-sm-8">{{ $item->grupo_Taxonomico }}</dd>
      <dt class="col-sm-4">Region</dt>
      <dd class="col-sm-8">{{ $item->region }}</dd>
      <dt class="col-sm-4">Tecnologia</dt>
      <dd class="col-sm-8">{{ $item->tecnologia }}</dd>
      <dt class="col-sm-4">Proyecto tesis</dt>
      <dd class="col-sm-8">{{ $item->proyecto_Tesis }}</dd>
      <dt class="col-sm-4">Longitud primer</dt>
      <dd class="col-sm-8">{{ $item->longitud_Primer }}</dd>
      <dt class="col-sm-4">Longitud amplicon</dt>
      <dd class="col-sm-8">{{ $item->Longitud_amplicon }}</dd>
      <dt class="col-sm-4">Gc</dt>
      <dd class="col-sm-8">{{ $item->gc }}</dd>
      <dt class="col-sm-4">Dnameltingpoint</dt>
      <dd class="col-sm-8">{{ $item->dnaMeltingPoint }}</dd>
      <dt class="col-sm-4">Annealing temperature</dt>
      <dd class="col-sm-8">{{ $item->annealing_Temperature }}</dd>
      <dt class="col-sm-4">Primerstaff</dt>
      <dd class="col-sm-8">{{ $item->primerStaff }}</dd>
      <dt class="col-sm-4">Fecha orden</dt>
      <dd class="col-sm-8">{{ $item->fecha_orden }}</dd>
      <dt class="col-sm-4">Proveedor</dt>
      <dd class="col-sm-8">{{ $item->proveedor }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('tbl-primers-f.index') }}">Volver</a>
      <a class="btn" href="{{ route('tbl-primers-f.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
