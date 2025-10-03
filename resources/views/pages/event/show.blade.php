@extends('layouts.sidebar')
@section('page_title','Detalle — Event')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Detalle — Event #{ $item->eventID }</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-4">Eventid</dt>
      <dd class="col-sm-8">{{ $item->eventID }}</dd>
      <dt class="col-sm-4">Parenteventid</dt>
      <dd class="col-sm-8">{{ $item->parentEventID }}</dd>
      <dt class="col-sm-4">Eventdate</dt>
      <dd class="col-sm-8">{{ $item->eventDate }}</dd>
      <dt class="col-sm-4">Eventtime</dt>
      <dd class="col-sm-8">{{ $item->eventTime }}</dd>
      <dt class="col-sm-4">Year</dt>
      <dd class="col-sm-8">{{ $item->year }}</dd>
      <dt class="col-sm-4">Month</dt>
      <dd class="col-sm-8">{{ $item->month }}</dd>
      <dt class="col-sm-4">Day</dt>
      <dd class="col-sm-8">{{ $item->day }}</dd>
      <dt class="col-sm-4">Habitat</dt>
      <dd class="col-sm-8">{{ $item->habitat }}</dd>
      <dt class="col-sm-4">Samplingprotocol</dt>
      <dd class="col-sm-8">{{ $item->samplingProtocol }}</dd>
      <dt class="col-sm-4">Fieldnotes</dt>
      <dd class="col-sm-8">{{ $item->fieldNotes }}</dd>
      <dt class="col-sm-4">Locationid</dt>
      <dd class="col-sm-8">{{ $item->locationID }}</dd>
      <dt class="col-sm-4">Eventremarks</dt>
      <dd class="col-sm-8">{{ $item->eventRemarks }}</dd>
    </dl>

    <div style="margin-top:12px;">
      <a class="btn" href="{{ route('location.index') }}">Volver</a>
      <a class="btn" href="{{ route('event.edit', $item) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
