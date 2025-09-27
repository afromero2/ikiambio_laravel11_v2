<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Taxon;
use App\Models\Vocab\Taxon\TaxonRank;
use App\Models\Vocab\Taxon\TaxonomicStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $data = $this->rules($request);

        $id = $data['taxonID'] ?: Str::uuid()->toString();

        DB::transaction(function () use (&$id, $data) {
            Taxon::updateOrCreate(
                ['taxonID' => $id],
                collect($data)->except('taxonID')->toArray()
            );
        });

        return redirect()->route('taxon.show', $id)->with('ok','Taxon creado');
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
        $data = $this->rules($request, updating:true);

        DB::transaction(function () use ($taxon, $data) {
            // No cambiar la PK aquí
            $taxon->update(collect($data)->except('taxonID')->toArray());
        });

        return redirect()->route('taxon.index', $taxon->taxonID)->with('ok','Taxon actualizado');
    }

    public function destroy(Taxon $taxon)
    {
        DB::transaction(function () use ($taxon) {
            $taxon->delete();
        });

        return redirect()->route('taxon.index')->with('ok','Taxon eliminado');
    }

    private function rules(Request $request, bool $updating=false): array
    {
        return $request->validate([
            'taxonID'                 => ['nullable','string','max:100'],
            'scientificNameID'        => ['nullable','string','max:100'],
            'scientificName'          => ['required','string','max:255'],
            'namePublishedIn'         => ['nullable','string'],
            'namePublishedInYear'     => ['nullable','integer'],
            'higherClassification'    => ['nullable','string'],
            'kingdom'                 => ['nullable','string','max:100'],
            'phylum'                  => ['nullable','string','max:100'],
            'class'                   => ['nullable','string','max:100'],
            'order'                   => ['nullable','string','max:100'],
            'family'                  => ['nullable','string','max:100'],
            'genus'                   => ['nullable','string','max:100'],
            'subgenus'                => ['nullable','string','max:100'],
            'specificEpithet'         => ['nullable','string','max:100'],
            'intraspecificEpithet'    => ['nullable','string','max:100'],
            'taxonRank'               => ['nullable','integer'],   // FK vocab
            'verbatimTaxonRank'       => ['nullable','string','max:50'],
            'scientificNameAuthorship'=> ['nullable','string'],
            'vernacularName'          => ['nullable','string'],
            'taxonomicStatus'         => ['nullable','integer'],   // FK vocab
            'taxonRemarks'            => ['nullable','string'],
        ]);
    }
}
