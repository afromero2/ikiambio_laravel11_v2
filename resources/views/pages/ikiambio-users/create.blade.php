
{{-- @extends('layouts.app') --}}
@extends('layouts.sidebar')
@section('title','Nuevo usuario')

@section('content')
<h1 class="h4 mb-3">Nuevo usuario</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
          {{ __('validation.txtValidacion') }}
        </div>
      @endif

<form method="POST" action="{{ route('ikiambio-users.store') }}" class="card card-body">
  @csrf

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">UtplId</label>
      <input name="utplId" value="{{ old('utplId') }}" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Identificación</label>
      <input name="identification" value="{{ old('identification') }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Nombres *</label>
      <input name="firstName" value="{{ old('firstName') }}" required class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Apellidos *</label>
      <input name="lastName" value="{{ old('lastName') }}" required class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Username *</label>
      <input name="username" value="{{ old('username') }}" required class="form-control">
    </div>
  </div>

  <div class="mt-3">
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('ikiambio-users.index') }}" class="btn btn-link">Cancelar</a>
  </div>
</form>
@endsection