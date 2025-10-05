<?php

namespace App\Http\Controllers\Web\Taxon;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Taxon\TaxonRank;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TaxonRankController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = TaxonRank::orderByDesc('taxonRank_id')->paginate(15);
        return view('pages.vocab-taxon-taxon-rank.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-taxon-taxon-rank.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['taxonRank_id'] ?? null)) {
                $data['taxonRank_id'] = (string) Str::uuid();
            }
            TaxonRank::create($data);
            return redirect()->route('vocab-taxon-taxon-rank.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(TaxonRank $taxonRank)
    {
        return view('pages.vocab-taxon-taxon-rank.show', ['item' => $taxonRank]);
    }

    public function edit(TaxonRank $taxonRank)
    {
        return view('pages.vocab-taxon-taxon-rank.edit', ['item' => $taxonRank]);
    }

    public function update(Request $request, TaxonRank $taxonRank)
    {
        try {
            $data = $request->validate($this->rules($taxonRank));
            $taxonRank->update($data);
            return redirect()->route('vocab-taxon-taxon-rank.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(TaxonRank $taxonRank)
    {
        try {
            $this->tx(fn () => $taxonRank->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($taxonRank = null): array
    {
        return [
            'taxonRank_value' => [
                'required','string','max:50',
                Rule::unique('vocab_taxon_taxonRank','taxonRank_value')
                ->ignore($taxonRank?->taxonRank_id,'taxonRank_id')
            ],
            'description' => ['required','string'],
        ];

    }

}
