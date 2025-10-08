<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Taxon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxonController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            /* 'taxonID'               => ['nullable','string','max:100','unique:taxon,taxonID'], */
            'scientificNameID'      => ['required','string','max:100'],
            'scientificName'        => ['required','string','max:255'],
            'namePublishedIn'       => ['required','string'],
            'namePublishedInYear'   => ['required','integer'],
            'higherClassification'  => ['required','string'],
            'kingdom'               => ['required','string','max:100'],
            'phylum'                => ['required','string','max:100'],
            'class'                 => ['required','string','max:100'],
            'order'                 => ['required','string','max:100'],
            'family'                => ['required','string','max:100'],
            'genus'                 => ['required','string','max:100'],
            'subgenus'              => ['required','string','max:100'],
            'specificEpithet'       => ['required','string','max:100'],
            'intraspecificEpithet'  => ['required','string','max:100'],
            'taxonRank'             => ['required','integer'], // FK a vocab rank
            'verbatimTaxonRank'     => ['required','string','max:50'],
            'scientificNameAuthorship' => ['required','string'],
            'vernacularName'        => ['required','string'],
            'taxonomicStatus'       => ['required','integer'], // FK a vocab status
            'taxonRemarks'          => ['required','string']
        ]);

        if (empty($data['taxonID'])) {
            $data['taxonID'] = (string) \Illuminate\Support\Str::uuid();
        }

        $tax = DB::transaction(fn() => Taxon::create($data));

        // Etiqueta legible
        $pieces = array_filter([
            $tax->scientificName,
            $tax->genus ? 'genus: '.$tax->genus : null,
            $tax->family ? 'family: '.$tax->family : null,
            $tax->kingdom ? 'kingdom: '.$tax->kingdom : null,
        ]);
        $label = $tax->taxonID.' — '.implode(' • ', array_map(fn($x)=>\Illuminate\Support\Str::limit($x,50), $pieces));

        return response()->json([
            'id'    => $tax->taxonID,
            'label' => $label,
        ]);
    }

    public function search(Request $request)
    {
        $q = trim((string)$request->query('q',''));
        if ($q === '') return response()->json([]);

        $like = "%{$q}%";

        $rows = Taxon::query()
            ->where('taxonID', 'ilike', $like)
            ->orWhere('scientificName', 'ilike', $like)
            ->orWhere('kingdom', 'ilike', $like)
            ->orWhere('family', 'ilike', $like)
            ->orWhere('genus', 'ilike', $like)
            ->orWhere('vernacularName', 'ilike', $like)
            ->orderBy('scientificName')
            ->limit(20)
            ->get([
                'taxonID','scientificName','kingdom','family','genus','vernacularName'
            ]);

        $items = $rows->map(function($r){
            $parts = array_filter([
                $r->scientificName,
                $r->genus ? 'genus: '.$r->genus : null,
                $r->family ? 'family: '.$r->family : null,
                $r->kingdom ? 'kingdom: '.$r->kingdom : null,
                $r->vernacularName ? 'vernacular: '.\Illuminate\Support\Str::limit($r->vernacularName,40) : null,
            ]);
            return [
                'id'   => $r->taxonID,
                'text' => $r->taxonID.' — '.implode(' • ', $parts)
            ];
        });

        if ($items->isEmpty()) {
            return response()->json([['id'=>'', 'text'=>'— Sin resultados —']]);
        }

        return response()->json($items);
    }
}
