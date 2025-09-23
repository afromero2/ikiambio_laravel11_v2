@extends('layouts.sidebar')
@section('page_title','Vocab identification typestatus')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Vocab identification typestatus</h1>
  <a href="{{ route('vocab-identification-type-status.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Vocab identification typestatus id</th>
            <th>Typestatus value</th>
            <th>Description</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->vocab_identification_typeStatus_id }}</td>
            <td>{{ $item->typeStatus_value }}</td>
            <td>{{ $item->description }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('vocab-identification-type-status.show', $item) }}">Ver</a>
              <a class="btn ghost warn" href="{{ route('vocab-identification-type-status.edit', $item) }}">Editar</a>
              <form style="display:inline" method="POST" action="{{ route('vocab-identification-type-status.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
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
  {{ $items->links() }}
</div>
@endsection
