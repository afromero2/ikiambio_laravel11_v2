@extends('layouts.sidebar')
@section('page_title','Tblfechapcr')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Tblfechapcr</h1>
  <a href="{{ route('tbl-fecha-pcr.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Idfechapcr</th>
            <th>Amplificationdate</th>
            <th>Amplificationmethod</th>
            <th>Lugar process</th>
            <th>Amplificationstaff</th>
            <th>Num reacciones</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->idFechaPCR }}</td>
            <td>{{ $item->amplificationDate }}</td>
            <td>{{ $item->amplificationMethod }}</td>
            <td>{{ $item->lugar_process }}</td>
            <td>{{ $item->amplificationStaff }}</td>
            <td>{{ $item->num_reacciones }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('tbl-fecha-pcr.show', $item) }}"><i class="fa fa-eye"></i></a>
              <a class="btn ghost" href="{{ route('tbl-fecha-pcr.edit', $item) }}"><i class="fa fa-edit"></i></a>
              <form style="display:inline" method="POST" action="{{ route('tbl-fecha-pcr.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
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
