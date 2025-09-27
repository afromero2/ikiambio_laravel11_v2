@extends('layouts.sidebar')
@section('page_title','Tblregistroslaboratorio')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Tblregistroslaboratorio</h1>
  <a href="{{ route('TblRegistrosLaboratorio.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Idregistroslaboratorio</th>
            <th>Idfechapcr</th>
            <th>Idextracciones</th>
            <th>Vol adn pcr</th>
            <th>Amplificationsuccess</th>
            <th>Amplificationsuccessdetails</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->idRegistrosLaboratorio }}</td>
            <td>{{ $item->idFechaPCR }}</td>
            <td>{{ $item->idExtracciones }}</td>
            <td>{{ $item->vol_ADN_PCR }}</td>
            <td>{{ $item->amplificationSuccess }}</td>
            <td>{{ $item->amplificationSuccessDetails }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('tbl-registros-laboratorio.show', $item) }}"><i class="fa fa-eye"></i></a>
              <a class="btn ghost" href="{{ route('tbl-registros-laboratorio.edit', $item) }}"><i class="fa fa-edit"></i></a>
              <form style="display:inline" method="POST" action="{{ route('tbl-registros-laboratorio.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
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
