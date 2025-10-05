<?php

namespace App\Http\Controllers\Web\Taxon;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Taxon\TaxonomicStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TaxonomicStatusController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = TaxonomicStatus::orderByDesc('taxonomicStatus_id')->paginate(15);
        return view('pages.vocab-taxon-taxonomic-status.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-taxon-taxonomic-status.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['taxonomicStatus_id'] ?? null)) {
                $data['taxonomicStatus_id'] = (string) Str::uuid();
            }
            TaxonomicStatus::create($data);
            return redirect()->route('vocab-taxon-taxonomic-status.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(TaxonomicStatus $taxonomicStatus)
    {
        return view('pages.vocab-taxon-taxonomic-status.show', ['item' => $taxonomicStatus]);
    }

    public function edit(TaxonomicStatus $taxonomicStatus)
    {
        return view('pages.vocab-taxon-taxonomic-status.edit', ['item' => $taxonomicStatus]);
    }

    public function update(Request $request, TaxonomicStatus $taxonomicStatus)
    {
        try {
            $data = $request->validate($this->rules($taxonomicStatus));
            $taxonomicStatus->update($data);
            return redirect()->route('vocab-taxon-taxonomic-status.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(TaxonomicStatus $taxonomicStatus)
    {
        try {
            $this->tx(fn () => $taxonomicStatus->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($taxonomicStatus = null): array
    {
        return [
            'taxonomicStatus_value' => [
                'required','string','max:50',
                Rule::unique('vocab_taxon_taxonomicStatus','taxonomicStatus_value')
                ->ignore($taxonomicStatus?->taxonomicStatus_id,'taxonomicStatus_id')
            ],
            'description' => ['required','string'],
        ];

    }

}
