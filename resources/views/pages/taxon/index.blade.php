@extends('layouts.sidebar')

@section('title','Taxon — Lista')
@section('page_title','Taxon')

@section('content')
  @php use Illuminate\Support\Str; @endphp

  <div class="d-flex justify-content-between align-items-center mb-3 btnForms">
    <h2 class="m-0">Taxon</h2>
    <a href="{{ route('taxon.create') }}" class="btn btn-primary">Nuevo</a>
  </div>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table align-middle"> 
        <thead>
          <tr class="text-center">
            <th class="text-center">Taxon ID</th>
            <th class="text-center">Scientific Name</th>
            <th class="text-center">Rank</th>
            <th class="text-center">Status</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @php $page = $items->currentPage() ?? old('page', request('page', 1)); @endphp
          @forelse($items as $row)
            <tr>
              <td class="fw-semibold">{{ $row->taxonID }}</td>
              <td>{{ Str::limit($row->scientificName, 80) }}</td>
              <td>{{ $row->taxonRankRef?->taxonRank_value }}</td>
              <td>{{ $row->taxonomicStatusRef?->taxonomicStatus_value }}</td>
              <td class="text-end">
                <a href="{{ route('taxon.show',['taxon' => $row->taxonID, 'page' => $page]) }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                <a href="{{ route('taxon.edit',['taxon' => $row->taxonID, 'page' => $page]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
                <form action="{{ route('taxon.destroy',['taxon' => $row ?? $taxon, 'page' => $page]) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este registro?')">
                  @csrf @method('DELETE')
                  <input type="hidden" name="page" value="{{ $page }}">
                  <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted">Sin registros</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{{ $items->links() }}}
  </div>
@endsection
