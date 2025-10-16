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
    /* public function index()
    {
        $items = Taxon::with(['taxonRankRef','taxonomicStatusRef'])
            ->orderBy('scientificName')
            ->paginate(15);

        return view('pages.taxon.index', compact('items'));
    } */

    public function index(Request $request)
    {
        $sessionKey = 'taxon.filters';

        if ($request->has('clear')) {
             session()->forget("$sessionKey.q");
            return redirect()->route('taxon.index');
        }

        $q = trim($request->get('q', ''));
        $allowed = [1, 2, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 100, 200, 300, 500, 1000];
        $perPage = (int) $request->query('per_page', (int) session("$sessionKey.per_page", 25));
        
        /* $q = $request->query('q', session("$sessionKey.q", '')); */

        $q = $request->has('q')? trim((string) $request->query('q', '')): (string) session("$sessionKey.q", '');

        if ($request->has('q') && $q === '') {
            session([$sessionKey => ['q' => '', 'per_page' => $perPage]]);
            // Redirige para quitar ?q= de la URL y evitar confusiones visuales
            return redirect()->route('taxon.index', ['per_page' => $perPage]);
        }

        if (!in_array($perPage, $allowed, true)) {
            $perPage = 25;
        }

        session([$sessionKey => ['q' => $q, 'per_page' => $perPage]]);

        $items = Taxon::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('taxonID', 'ILIKE', "%{$q}%")
                    ->orWhere('scientificNameID', 'ILIKE', "%{$q}%")
                    ->orWhere('scientificName', 'ILIKE', "%{$q}%")
                    ->orWhere('namePublishedIn', 'ILIKE', "%{$q}%")
                    ->orWhere('namePublishedInYear', 'ILIKE', "%{$q}%")
                    ->orWhere('higherClassification', 'ILIKE', "%{$q}%")
                    ->orWhere('kingdom', 'ILIKE', "%{$q}%")
                    ->orWhere('phylum', 'ILIKE', "%{$q}%")
                    ->orWhere('class', 'ILIKE', "%{$q}%")
                    ->orWhere('order', 'ILIKE', "%{$q}%")
                    ->orWhere('family', 'ILIKE', "%{$q}%")
                    ->orWhere('genus', 'ILIKE', "%{$q}%")
                    ->orWhere('subgenus', 'ILIKE', "%{$q}%")
                    ->orWhere('specificEpithet', 'ILIKE', "%{$q}%")
                    ->orWhere('intraspecificEpithet', 'ILIKE', "%{$q}%")
                    ->orWhere('taxonRank', 'ILIKE', "%{$q}%")
                    ->orWhere('verbatimTaxonRank', 'ILIKE', "%{$q}%")
                    ->orWhere('scientificNameAuthorship', 'ILIKE', "%{$q}%")
                    ->orWhere('vernacularName', 'ILIKE', "%{$q}%")
                    ->orWhere('taxonomicStatus', 'ILIKE', "%{$q}%")
                    ->orWhere('taxonRemarks', 'ILIKE', "%{$q}%");
                });
            })
            ->orderBy('taxonID')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.taxon.index', compact('items', 'q', 'perPage', 'allowed'));
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
            'namePublishedIn'         => ['nullable','string'],
            'namePublishedInYear'     => ['nullable','integer'],
            'higherClassification'    => ['nullable','string'],
            'kingdom' => ['nullable','string','max:100'],
            'phylum'  => ['nullable','string','max:100'],
            'class'   => ['required','string','max:100'],
            'order'   => ['required','string','max:100'],
            'family'  => ['required','string','max:100'],
            'genus'   => ['required','string','max:100'],
            'subgenus'=> ['nullable','string','max:100'],
            'specificEpithet'      => ['nullable','string','max:100'],
            'intraspecificEpithet' => ['nullable','string','max:100'],
            'taxonRank'            => ['required','integer','exists:vocab_taxon_taxonRank,taxonRank_id'],
            'verbatimTaxonRank'    => ['nullable','string','max:50'],
            'scientificNameAuthorship'=> ['required','string'],
            'vernacularName'          => ['nullable','string'],
            'taxonomicStatus'         => ['nullable','integer','exists:vocab_taxon_taxonomicStatus,taxonomicStatus_id'],
            'taxonRemarks'            => ['nullable','string']
        ];
    }
}
