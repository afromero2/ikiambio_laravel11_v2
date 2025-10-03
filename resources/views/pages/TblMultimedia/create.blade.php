@extends('layouts.sidebar')
@section('page_title','Nuevo — Tblmultimedia')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Tblmultimedia</h1>

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

<form method="POST" action="{{ route('tbl-multimedia.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Id occ bd</label>
      {{-- <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', isset($item)? $item->id_occ_bd : '') }}" class="input"> --}}
      <input type="text" name="id_occ_bd" value="{{ old('id_occ_bd', $occurrenceId) }}" class="input" readonly>
    </div>

    <div>
      <label class="label">Type</label>
      <input type="text" name="type" value="{{ old('type', isset($item)? $item->type : '') }}" class="input">
    </div>

    <div>
      <label class="label">Format</label>
      <input type="text" name="format" value="{{ old('format', isset($item)? $item->format : '') }}" class="input">
    </div>

    <div>
      <label class="label">Identifier</label>
      <textarea name="identifier" class="input" rows="3">{{ old('identifier', isset($item)? $item->identifier : '') }}</textarea>
    </div>

    <div>
      <label class="label">Title</label>
      <input type="text" name="title" value="{{ old('title', isset($item)? $item->title : '') }}" class="input">
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
    </div>

    <div>
      <label class="label">Created</label>
      <input type="date" name="created" value="{{ old('created', isset($item)? $item->created : '') }}" class="input">
    </div>

    <div>
      <label class="label">Creator</label>
      <input type="text" name="creator" value="{{ old('creator', isset($item)? $item->creator : '') }}" class="input">
    </div>

    <div>
      <label class="label">Contributor</label>
      <input type="text" name="contributor" value="{{ old('contributor', isset($item)? $item->contributor : '') }}" class="input">
    </div>

    <div>
      <label class="label">Publisher</label>
      <input type="text" name="publisher" value="{{ old('publisher', isset($item)? $item->publisher : '') }}" class="input">
    </div>

    <div>
      <label class="label">License</label>
      <input type="text" name="license" value="{{ old('license', isset($item)? $item->license : '') }}" class="input">
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('occurrence.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
