<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Collectionid;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        try {
            $data = $request->validate($this->rules());
            if (empty($data['collection_id'] ?? null)) {
                $data['collection_id'] = (string) Str::uuid();
            }
            Collectionid::create($data);
            return redirect()->route('vocab-record-level-collection-id.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
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
        try {
            $data = $request->validate($this->rules($collectionId));
            $collectionId->update($data);
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

    protected function rules($collectionId = null): array
    {
        return [
            'collection_value' => [
                'required','string','max:100',
                Rule::unique('vocab_record_level_collectionID','collection_value')
                ->ignore($collectionId?->collection_id, 'collection_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
