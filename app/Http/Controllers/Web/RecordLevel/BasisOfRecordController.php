<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\BasisOfRecord;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BasisOfRecordController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = BasisOfRecord::orderByDesc('basisofrecord_id')->paginate(15);
        return view('pages.vocab-record-level-basis-of-record.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-basis-of-record.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['basisofrecord_id'] ?? null)) {
                $data['basisofrecord_id'] = (string) Str::uuid();
            }
            BasisOfRecord::create($data);
            return redirect()->route('vocab-record-level-basis-of-record.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(BasisOfRecord $basisOfRecord)
    {
        return view('pages.vocab-record-level-basis-of-record.show', ['item' => $basisOfRecord]);
    }

    public function edit(BasisOfRecord $basisOfRecord)
    {
        return view('pages.vocab-record-level-basis-of-record.edit', ['item' => $basisOfRecord]);
    }

    public function update(Request $request, BasisOfRecord $basisOfRecord)
    {
        try {
            $data = $request->validate($this->rules($basisOfRecord));
            $basisOfRecord->update($data);
            return redirect()->route('vocab-record-level-basis-of-record.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(BasisOfRecord $basisOfRecord)
    {
        try {
            $this->tx(fn () => $basisOfRecord->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($basisOfRecord = null): array
    {
        return [
            'basisofrecord_value' => [
                'required','string','max:50',
                Rule::unique('vocab_record_level_basisOfRecord','basisofrecord_value')
                ->ignore($basisOfRecord?->basisofrecord_id, 'basisofrecord_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
