@extends('layouts.sidebar')
@section('page_title','Vocab occurrence reproductivecondition')

@section('content')
<div class="d-flex" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
  <h1 style="margin:0;font-size:1.25rem;">Vocab occurrence reproductivecondition</h1>
  <a href="{{ route('vocab-occurrence-reproductive-condition.create') }}" class="btn primary">Nuevo</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div style="overflow:auto;">
      <table class="table">
        <thead>
          <tr>
            <th>Reprocond id</th>
            <th>Reprocond value</th>
            <th>Description</th>
            <th style="text-align:right;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->reprocond_id }}</td>
            <td>{{ $item->reprocond_value }}</td>
            <td>{{ $item->description }}</td>
            <td style="text-align:right;">
              <a class="btn ghost" href="{{ route('vocab-occurrence-reproductive-condition.show', $item) }}"><i class="fa fa-eye"></i></a>
              <a class="btn ghost" href="{{ route('vocab-occurrence-reproductive-condition.edit', $item) }}"><i class="fa fa-edit"></i></a>
              <form style="display:inline" method="POST" action="{{ route('vocab-occurrence-reproductive-condition.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button class="btn ghost " type="submit"><i class="fa fa-trash"></i></button>
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
