<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Institutionid;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InstitutionIdController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Institutionid::orderByDesc('institution_id')->paginate(15);
        return view('pages.vocab-record-level-institution-id.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-institution-id.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['institution_id'] ?? null)) {
                $data['institution_id'] = (string) Str::uuid();
            }
            Institutionid::create($data);
            return redirect()->route('vocab-record-level-institution-id.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Institutionid $institutionId)
    {
        return view('pages.vocab-record-level-institution-id.show', ['item' => $institutionId]);
    }

    public function edit(Institutionid $institutionId)
    {
        return view('pages.vocab-record-level-institution-id.edit', ['item' => $institutionId]);
    }

    public function update(Request $request, Institutionid $institutionId)
    {
        try {
            $data = $request->validate($this->rules($institutionId));
            $institutionId->update($data);
            return redirect()->route('vocab-record-level-institution-id.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Institutionid $institutionId)
    {
        try {
            $this->tx(fn () => $institutionId->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($institutionId = null): array
    {
        return [
            'institutionID_value' => [
                'required','string','max:50',
                Rule::unique('vocab_record_level_institutionID','institutionID_value')
                ->ignore($institutionId?->institution_id, 'institution_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
