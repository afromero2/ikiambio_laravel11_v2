@extends('layouts.sidebar')
@section('page_title','Tblprimersr')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Tblprimersr</h1>
  <a href="{{ route('tbl-primers-r.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Idprimers</th>
            <th>Genabrev</th>
            <th>Genname</th>
            <th>Primername</th>
            <th>Primersequence</th>
            <th>Primerreferencecitation</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->idPrimersr }}</td>
            <td>{{ $item->genAbrev }}</td>
            <td>{{ $item->genName }}</td>
            <td>{{ $item->primerName }}</td>
            <td>{{ $item->primerSequence }}</td>
            <td>{{ $item->primerReferenceCitation }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('tbl-primers-r.show', $item) }}"><i class="fa fa-eye"></i></a>
              <a class="btn ghost" href="{{ route('tbl-primers-r.edit', $item) }}"><i class="fa fa-edit"></i></a>
              <form style="display:inline" method="POST" action="{{ route('tbl-primers-r.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button class="btn ghost " type="submit"><i class="fa fa-trash"></i></button>
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
