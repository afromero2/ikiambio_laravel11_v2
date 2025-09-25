<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Collectionid;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CollectionIdController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Collectionid::orderByDesc('collection_id')->paginate(15);
        return view('pages.vocab-record-level-collection-id.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-collection-id.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Collectionid::create($data));
            return redirect()->route('vocab-record-level-collection-id.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crearrrr.')->withInput();
        }
    }

    public function show(Collectionid $collectionId)
    {
        return view('pages.vocab-record-level-collection-id.show', ['item' => $collectionId]);
    }

    public function edit(Collectionid $collectionId)
    {
        return view('pages.vocab-record-level-collection-id.edit', ['item' => $collectionId]);
    }

    public function update(Request $request, Collectionid $collectionId)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $collectionId->update($data));
            return redirect()->route('vocab-record-level-collection-id.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Collectionid $collectionId)
    {
        try {
            $this->tx(fn () => $collectionId->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
