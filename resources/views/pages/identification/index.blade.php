@extends('layouts.sidebar')
@section('page_title','Identification')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Identification</h1>
  <a href="{{ route('identification.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Identificationid</th>
            <th>Identificationqualifier</th>
            <th>Typestatus</th>
            <th>Identifiedby</th>
            <th>Dateidentified</th>
            <th>Identificationverificationstatus</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->identificationID }}</td>
            <td>{{ $item->identificationQualifier }}</td>
            <td>{{ $item->typeStatus }}</td>
            <td>{{ $item->identifiedBy }}</td>
            <td>{{ $item->dateIdentified }}</td>
            <td>{{ $item->identificationVerificationStatus }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('identification.show', $item) }}">Ver</a>
              <a class="btn ghost warn" href="{{ route('identification.edit', $item) }}">Editar</a>
              <form style="display:inline" method="POST" action="{{ route('identification.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
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
