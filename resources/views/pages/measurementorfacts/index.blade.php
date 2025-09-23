@extends('layouts.sidebar')
@section('page_title','Measurementorfacts')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Measurementorfacts</h1>
  <a href="{{ route('measurement-or-facts.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Measurementid</th>
            <th>Id occ bd</th>
            <th>Measurementtype</th>
            <th>Measurementvalue</th>
            <th>Measurementaccuracy</th>
            <th>Measurementunit</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->measurementID }}</td>
            <td>{{ $item->id_occ_bd }}</td>
            <td>{{ $item->measurementType }}</td>
            <td>{{ $item->measurementValue }}</td>
            <td>{{ $item->measurementAccuracy }}</td>
            <td>{{ $item->measurementUnit }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('measurement-or-facts.show', $item) }}">Ver</a>
              <a class="btn ghost warn" href="{{ route('measurement-or-facts.edit', $item) }}">Editar</a>
              <form style="display:inline" method="POST" action="{{ route('measurement-or-facts.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
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
