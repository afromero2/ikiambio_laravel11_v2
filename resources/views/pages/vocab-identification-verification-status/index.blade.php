@extends('layouts.sidebar')
@section('page_title','Vocab identification verificationstatus')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Vocab identification verificationstatus</h1>
  <a href="{{ route('vocab-identification-verification-status.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Vocab identification verificationstatus id</th>
            <th>Identificationverificationstatus value</th>
            <th>Description</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->vocab_identification_verificationStatus_id }}</td>
            <td>{{ $item->identificationVerificationStatus_value }}</td>
            <td>{{ $item->description }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('vocab-identification-verification-status.show', $item) }}">Ver</a>
              <a class="btn ghost warn" href="{{ route('vocab-identification-verification-status.edit', $item) }}">Editar</a>
              <form style="display:inline" method="POST" action="{{ route('vocab-identification-verification-status.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
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
  { $items->links() }
</div>
@endsection
