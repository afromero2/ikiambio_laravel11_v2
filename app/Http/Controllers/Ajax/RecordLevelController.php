<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

// Modelos principales
use App\Models\RecordLevel;

class RecordLevelController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q',''));

        if ($q === '') {
            return response()->json([]);
        }

        // aparezca también en resultados para poder re-usarlo.
        $currentId = $request->query('current_id'); // ej: /search?q=pepe&current_id=12

        $builder = RecordLevel::query();

        // 1) Restringe a los que NO están asociados a Occurrence (o el current_id si fue pasado)
        $builder->where(function ($w) use ($currentId) {
            // NOT IN (SELECT record_level_id FROM occurrence WHERE record_level_id IS NOT NULL)
            $w->whereNotIn('record_level_id', function ($sub) {
                $sub->select('record_level_id')
                    ->from('occurrence')
                    ->whereNotNull('record_level_id');
            });

            if ($currentId) {
                // Incluye el actual si se está editando
                $w->orWhere('record_level_id', (int) $currentId);
            }
        });

        // 2) Búsqueda por texto/ID (agrupada para no romper la condición anterior)
        $builder->where(function ($w) use ($q) {
            if (ctype_digit($q)) {
                $w->orWhere('record_level_id', (int) $q);
            }
            $w->orWhere('datasetName', 'ilike', "%{$q}%")
            ->orWhere('references',  'ilike', "%{$q}%")
            ->orWhere('datasetID',   'ilike', "%{$q}%");
        });

        // 3) Orden, límite y columnas
        $rows = $builder
            ->orderByDesc('record_level_id')
            ->limit(20)
            ->get(['record_level_id','datasetName','references','datasetID']);

        // 4) Formato select2-like
        $items = $rows->map(function ($r) {
            $label = '#'.$r->record_level_id.' - '.$r->references.' - '.$r->datasetID;
            if (!empty($r->datasetName)) {
                $label .= ' - '.$r->datasetName;
            }
            return [
                'id'   => $r->record_level_id,
                'text' => $label,
            ];
        });

        return response()->json($items);
    }    

    /** POST /ajax/record-levels  => { id }  (crea o actualiza si envían record_level_id) */
    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['record_level_id'] ?? null)) {
                $data['record_level_id'] = (string) Str::uuid();
            }
            RecordLevel::create($data);
            return redirect()->route('record-level.index')->with('ok', 'Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }

        return response()->json(['id' => $id]);
    }

    protected function rules($recordLevel = null): array
    {
        return [
            'type'        => ['required','integer','exists:vocab_record_level_type,type_id'],
            'modified'    => ['required','date'],
            'language'    => ['required','string','size:2'],
            'license'     => ['required','integer','exists:vocab_record_level_license,license_id'],
            'rightsHolder'=> ['required','integer','exists:vocab_record_level_rightsHolder,rightsHolder_id'],
            'accessRights'=> ['required','integer','exists:vocab_record_level_accessRights,accessrights_id'],
            'bibliographicCitation' => ['required','string'],
            'references'  => ['required','string'],
            'institutionID' => ['required','integer','exists:vocab_record_level_institutionID,institution_id'],
            'collectionID'  => ['required','integer','exists:vocab_record_level_collectionID,collection_id'],
            'datasetID'     => ['required','string','max:100'],
            'institutionCode'=> ['required','integer','exists:vocab_record_level_institutionCode,institutionCode_id'],
            'collectionCode' => ['required','integer','exists:vocab_record_level_collectionCode,collectionCode_id'],
            'datasetName'     => ['required','string','max:255'],
            'ownerInstitutionCode' => ['required','integer','exists:vocab_record_level_ownerInstitutionCode,ownerinstitutioncode_id'],
            'basisOfRecord'   => ['required','integer','exists:vocab_record_level_basisOfRecord,basisofrecord_id'],
            'informationWithheld' => ['required','string'],
            'dataGeneralizations'=> ['required','string']
        ];
    }

}
