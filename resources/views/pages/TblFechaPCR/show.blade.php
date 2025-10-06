@extends('layouts.sidebar')
@section('page_title','Detalle — Tblfechapcr')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Tblfechapcr #{ $item->idFechaPCR }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Idfechapcr</dt>
      <dd class="col-sm-8">{{ $item->idFechaPCR }}</dd>
      <dt class="col-sm-4">Amplificationdate</dt>
      <dd class="col-sm-8">{{ $item->amplificationDate }}</dd>
      <dt class="col-sm-4">Amplificationmethod</dt>
      <dd class="col-sm-8">{{ $item->amplificationMethod }}</dd>
      <dt class="col-sm-4">Lugar process</dt>
      <dd class="col-sm-8">{{ $item->lugar_process }}</dd>
      <dt class="col-sm-4">Amplificationstaff</dt>
      <dd class="col-sm-8">{{ $item->amplificationStaff }}</dd>
      <dt class="col-sm-4">Num reacciones</dt>
      <dd class="col-sm-8">{{ $item->num_reacciones }}</dd>
      <dt class="col-sm-4">Volumen finalrx</dt>
      <dd class="col-sm-8">{{ $item->volumen_finalRx }}</dd>
      <dt class="col-sm-4">Mastermix</dt>
      <dd class="col-sm-8">{{ $item->masterMix }}</dd>
      <dt class="col-sm-4">Clh20</dt>
      <dd class="col-sm-8">{{ $item->clh20 }}</dd>
      <dt class="col-sm-4">Buffer</dt>
      <dd class="col-sm-8">{{ $item->buffer }}</dd>
      <dt class="col-sm-4">Bsa</dt>
      <dd class="col-sm-8">{{ $item->bsa }}</dd>
      <dt class="col-sm-4">Mgcl</dt>
      <dd class="col-sm-8">{{ $item->mgcl }}</dd>
      <dt class="col-sm-4">Dntp</dt>
      <dd class="col-sm-8">{{ $item->dntp }}</dd>
      <dt class="col-sm-4">Primer f</dt>
      <dd class="col-sm-8">{{ $item->primer_F }}</dd>
      <dt class="col-sm-4">Primer r</dt>
      <dd class="col-sm-8">{{ $item->primer_R }}</dd>
      <dt class="col-sm-4">Taq</dt>
      <dd class="col-sm-8">{{ $item->taq }}</dd>
      <dt class="col-sm-4">Adn</dt>
      <dd class="col-sm-8">{{ $item->adn }}</dd>
      <dt class="col-sm-4">Equipo pcr</dt>
      <dd class="col-sm-8">{{ $item->equipo_PCR }}</dd>
      <dt class="col-sm-4">Pre c</dt>
      <dd class="col-sm-8">{{ $item->pre_c }}</dd>
      <dt class="col-sm-4">Pretiempo</dt>
      <dd class="col-sm-8">{{ $item->pretiempo }}</dd>
      <dt class="col-sm-4">Pcr1 c</dt>
      <dd class="col-sm-8">{{ $item->pcr1_c }}</dd>
      <dt class="col-sm-4">Pcr1tiempo</dt>
      <dd class="col-sm-8">{{ $item->pcr1tiempo }}</dd>
      <dt class="col-sm-4">Pcr2 c</dt>
      <dd class="col-sm-8">{{ $item->pcr2_c }}</dd>
      <dt class="col-sm-4">Pcr2tiempo</dt>
      <dd class="col-sm-8">{{ $item->pcr2tiempo }}</dd>
      <dt class="col-sm-4">Pcr3 c</dt>
      <dd class="col-sm-8">{{ $item->pcr3_c }}</dd>
      <dt class="col-sm-4">Pcr3tiempo</dt>
      <dd class="col-sm-8">{{ $item->pcr3tiempo }}</dd>
      <dt class="col-sm-4">Post c</dt>
      <dd class="col-sm-8">{{ $item->post_c }}</dd>
      <dt class="col-sm-4">Post tiempo</dt>
      <dd class="col-sm-8">{{ $item->post_tiempo }}</dd>
      <dt class="col-sm-4">Final c</dt>
      <dd class="col-sm-8">{{ $item->final_c }}</dd>
      <dt class="col-sm-4">Ciclos</dt>
      <dd class="col-sm-8">{{ $item->ciclos }}</dd>
      <dt class="col-sm-4">Imagenpcraccessionuri</dt>
      <dd class="col-sm-8">{{ $item->imagenPCRAccessionURI }}</dd>
      <dt class="col-sm-4">Imagenpcr</dt>
      <dd class="col-sm-8">{{ $item->imagenPCR }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('tbl-fecha-pcr.index') }}">Volver</a>
      <a class="btn" href="{{ route('tbl-fecha-pcr.edit', $item) }}">Editar</a>
    </div>
    
  </div>
</div>
@endsection
