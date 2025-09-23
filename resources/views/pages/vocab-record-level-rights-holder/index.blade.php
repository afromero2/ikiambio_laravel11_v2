@extends('layouts.sidebar')
@section('page_title','Rights holder')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Rights holder</h1>
  <a href="{{ route('vocab-record-level-rights-holder.create') }}" class="btn primary">Nuevo</a>
</div>

@if(session('ok'))
  <div class="alert alert-success" style="border:1px solid #bbf7d0;background:#dcfce7;color:#14532d;padding:8px 12px;margin-bottom:10px;">
    {{ session('ok') }}
  </div>
@endif

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>rightsHolder_value</th>
            <th>description</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->rightsHolder_id }}</td>
            <td>{{ $item->rightsHolder_value }}</td>
            <td>{{ Str::limit($item->description, 80) }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('vocab-record-level-rights-holder.show', $item) }}">Ver</a>
              <a class="btn ghost warn" href="{{ route('vocab-record-level-rights-holder.edit', $item) }}">Editar</a>
              <form style="display:inline" method="POST" action="{{ route('vocab-record-level-rights-holder.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button class="btn ghost danger" type="submit">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="text-align:center;color:#6b7280;padding:20px;">Sin registros</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div style="margin-top:12px;">
  {{{ $items->links() }}}
</div>
@endsection
