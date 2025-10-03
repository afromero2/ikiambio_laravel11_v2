@extends('layouts.sidebar')
@section('page_title','Nuevo — Event')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Event</h1>

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

<form method="POST" action="{{ route('event.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Locationid</label>
      <input type="text" name="locationID" value="{{ old('locationID', $locationId) }}" class="input" readonly>
    </div>

    <div>
      <label class="label">Parenteventid</label>
      <input type="text" name="parentEventID" value="{{ old('parentEventID', isset($item)? $item->parentEventID : '') }}" class="input">
    </div>

    <div>
      <label class="label">Eventdate</label>
      <input type="date" name="eventDate" value="{{ old('eventDate', isset($item)? $item->eventDate : '') }}" class="input">
    </div>

    <div>
      <label class="label">Eventtime</label>
      <input type="time" name="eventTime" value="{{ old('eventTime', isset($item)? $item->eventTime : '') }}" class="input">
    </div>

    <div>
      <label class="label">Year</label>
      <input type="number" name="year" value="{{ old('year', isset($item)? $item->year : '') }}" class="input">
    </div>

    <div>
      <label class="label">Month</label>
      <input type="number" name="month" value="{{ old('month', isset($item)? $item->month : '') }}" class="input">
    </div>

    <div>
      <label class="label">Day</label>
      <input type="number" name="day" value="{{ old('day', isset($item)? $item->day : '') }}" class="input">
    </div>

    <div>
      <label class="label">Habitat</label>
      <textarea name="habitat" class="input" rows="3">{{ old('habitat', isset($item)? $item->habitat : '') }}</textarea>
    </div>

    <div>
      <label class="label">Samplingprotocol</label>
      <textarea name="samplingProtocol" class="input" rows="3">{{ old('samplingProtocol', isset($item)? $item->samplingProtocol : '') }}</textarea>
    </div>

    <div>
      <label class="label">Fieldnotes</label>
      <textarea name="fieldNotes" class="input" rows="3">{{ old('fieldNotes', isset($item)? $item->fieldNotes : '') }}</textarea>
    </div>


    <div>
      <label class="label">Eventremarks</label>
      <textarea name="eventRemarks" class="input" rows="3">{{ old('eventRemarks', isset($item)? $item->eventRemarks : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('location.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
