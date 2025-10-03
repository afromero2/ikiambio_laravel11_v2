
{{-- @extends('layouts.app') --}}
@extends('layouts.sidebar') 
@section('title','Detalle usuario')

@section('content')
<h1 class="h4 mb-3">Usuario #{{ $user->id }}</h1>

<div class="card">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-3">Nombre</dt>
      <dd class="col-sm-9">{{ $user->full_name }}</dd>

      <dt class="col-sm-3">Username</dt>
      <dd class="col-sm-9">{{ $user->username }}</dd>

      <dt class="col-sm-3">UtplId</dt>
      <dd class="col-sm-9">{{ $user->utplId ?? '—' }}</dd>

      <dt class="col-sm-3">Identificación</dt>
      <dd class="col-sm-9">{{ $user->identification ?? '—' }}</dd>
    </dl>

    <div class="mt-3">
      <a class="btn btn-link" href="{{ route('ikiambio-users.index') }}">Volver</a>
      <a class="btn btn-outline-primary" href="{{ route('ikiambio-users.edit',$user) }}">Editar</a>
    </div>
  </div>
</div>
@endsection
