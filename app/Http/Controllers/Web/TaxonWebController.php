<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Taxon;
use App\Models\Vocab\Taxon\TaxonRank;
use App\Models\Vocab\Taxon\TaxonomicStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class TaxonWebController extends Controller
{
    public function index()
    {
        $items = Taxon::with(['taxonRankRef','taxonomicStatusRef'])
            ->orderBy('scientificName')
            ->paginate(15);

        return view('pages.taxon.index', compact('items'));
    }

    public function create()
    {
        $taxonRanks = TaxonRank::orderBy('taxonRank_value')
            ->get(['taxonRank_id','taxonRank_value']);
        $taxonomicStatuses = TaxonomicStatus::orderBy('taxonomicStatus_value')
            ->get(['taxonomicStatus_id','taxonomicStatus_value']);

        return view('pages.taxon.create', compact('taxonRanks','taxonomicStatuses'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['taxonID'] ?? null)) {
                $data['taxonID'] = (string) Str::uuid();
            }
            Taxon::create($data);
            return redirect()->route('taxon.index')->with('ok','Taxon creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
            /* return $e; */
        }
    }

    public function show(Taxon $taxon)
    {
        $item = $taxon->load(['taxonRankRef','taxonomicStatusRef']);
        return view('pages.taxon.show', compact('item'));
    }

    public function edit(Taxon $taxon)
    {
        $taxonRanks = TaxonRank::orderBy('taxonRank_value')->get(['taxonRank_id','taxonRank_value']);
        $taxonomicStatuses = TaxonomicStatus::orderBy('taxonomicStatus_value')->get(['taxonomicStatus_id','taxonomicStatus_value']);
        $item = $taxon;

        return view('pages.taxon.edit', compact('item','taxonRanks','taxonomicStatuses'));
    }

    public function update(Request $request, Taxon $taxon)
    {
        try {
            $data = $request->validate($this->rules($taxon));
            $taxon->update($data);

             // Toma la página desde el form o el querystring; fallback = 1
            $page = (int) $request->input('page', $request->query('page', 1)); 

            return redirect()->route('taxon.index', ['page' => max(1, $page)])->with('ok','Actualizado');

            /* return redirect()->route('taxon.index', ['page' => max(1, $page)])->with('ok', 'Actualizado'); */

        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Request $request, Taxon $taxon)
    {
        DB::transaction(function () use ($taxon) {
            $taxon->delete();
        });

        $page = (int) $request->input('page', $request->query('page', 1));
        /* return redirect()->route('taxon.index')->with('ok','Taxon eliminado'); */
        return redirect()->route('taxon.index', ['page' => max(1, $page)])->with('ok', 'Taxon eliminado');
    }

    protected function rules($taxon = null): array
    {
        return [
            'taxonID'                 => [$taxon ? 'sometimes' : 'nullable','string','max:100', Rule::unique('taxon','taxonID')->ignore($taxon?->taxonID,'taxonID')],
            'scientificNameID'        => ['required','string','max:100'],
            'scientificName'          => ['required','string','max:255'],
            'namePublishedIn'         => ['required','string'],
            'namePublishedInYear'     => ['required','integer'],
            'higherClassification'    => ['required','string'],
            'kingdom' => ['required','string','max:100'],
            'phylum'  => ['required','string','max:100'],
            'class'   => ['required','string','max:100'],
            'order'   => ['required','string','max:100'],
            'family'  => ['required','string','max:100'],
            'genus'   => ['required','string','max:100'],
            'subgenus'=> ['required','string','max:100'],
            'specificEpithet'      => ['required','string','max:100'],
            'intraspecificEpithet' => ['required','string','max:100'],
            'taxonRank'            => ['required','integer','exists:vocab_taxon_taxonRank,taxonRank_id'],
            'verbatimTaxonRank'    => ['required','string','max:50'],
            'scientificNameAuthorship'=> ['required','string'],
            'vernacularName'          => ['required','string'],
            'taxonomicStatus'         => ['required','integer','exists:vocab_taxon_taxonomicStatus,taxonomicStatus_id'],
            'taxonRemarks'            => ['required','string']
        ];
    }
}
