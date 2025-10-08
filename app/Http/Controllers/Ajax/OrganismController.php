<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Organism;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganismController extends Controller
{
    public function store(Request $request)
    {
        // Validación: si no pasas organismID, lo generamos (uuid)
        $data = $request->validate([
            /* 'organismID'               => ['nullable','string','max:255','unique:organism,organismID'], */
            'associatedOccurrences'    => ['required','string'],
            'associatedOrganisms'      => ['required','string'],
            'previousIdentifications'  => ['required','string']
        ]);

        if (empty($data['organismID'])) {
            $data['organismID'] = (string) \Illuminate\Support\Str::uuid();
        }

        $org = DB::transaction(fn() => Organism::create($data));

        // Construye label legible
        $labelParts = [$org->organismID];
        if ($org->associatedOccurrences)    $labelParts[] = \Illuminate\Support\Str::limit($org->associatedOccurrences, 40);
        if ($org->associatedOrganisms)      $labelParts[] = \Illuminate\Support\Str::limit($org->associatedOrganisms, 40);
        if ($org->previousIdentifications)  $labelParts[] = \Illuminate\Support\Str::limit($org->previousIdentifications, 40);

        return response()->json([
            'id'    => $org->organismID,
            'label' => implode(' — ', $labelParts),
        ]);
    }

    public function search(Request $request)
    {
        $q = trim((string)$request->query('q', ''));
        if ($q === '') return response()->json([]);

        $like = "%{$q}%";

        $rows = Organism::query()
            // si coincide EXACTAMENTE con el ID, dale prioridad
            ->when($q !== '', function ($qq) use ($q, $like) {
                $qq->where(function ($w) use ($q, $like) {
                    $w->where('organismID', 'ilike', $like)
                      ->orWhere('associatedOccurrences',   'ilike', $like)
                      ->orWhere('associatedOrganisms',     'ilike', $like)
                      ->orWhere('previousIdentifications', 'ilike', $like);
                });
            })
            ->orderBy('organismID') // ordenar por ID
            ->limit(20)
            ->get(['organismID', 'associatedOccurrences', 'associatedOrganisms', 'previousIdentifications']);

        $items = $rows->map(function ($r) {
            $bits = [
                $r->organismID,
                $r->associatedOccurrences,
                $r->associatedOrganisms,
                $r->previousIdentifications,
            ];
            $bits = array_values(array_filter($bits));
            $label = implode(' — ', array_map(fn($x) => \Illuminate\Support\Str::limit($x, 40), $bits));

            return ['id' => $r->organismID, 'text' => $label];
        });

        // Si no hay resultados
        if ($items->isEmpty()) {
            return response()->json([['id' => '', 'text' => '— Sin resultados —']]);
        }

        return response()->json($items);
    }
}
