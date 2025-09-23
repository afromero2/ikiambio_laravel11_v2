@extends('layouts.sidebar')
@section('page_title','TblExtractions')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">TblExtractions</h1>
  <a href="{{ route('tbl-extractions.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Idextracciones</th>
            <th>Id occ bd</th>
            <th>Materialsampletype</th>
            <th>Idregistros</th>
            <th>Fechaextraccion</th>
            <th>Purificationmethod</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->idExtracciones }}</td>
            <td>{{ $item->id_occ_bd }}</td>
            <td>{{ $item->materialSampleType }}</td>
            <td>{{ $item->idRegistros }}</td>
            <td>{{ $item->fechaExtraccion }}</td>
            <td>{{ $item->purificationMethod }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('tbl-extractions.show', $item) }}">Ver</a>
              <a class="btn ghost warn" href="{{ route('tbl-extractions.edit', $item) }}">Editar</a>
              <form style="display:inline" method="POST" action="{{ route('tbl-extractions.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button class="btn ghost danger" type="submit">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="text-align:center;color:#6b7280;padding:20px;">Sin registros</td></tr>
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
