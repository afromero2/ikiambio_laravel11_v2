<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Institutioncode;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InstitutionCodeController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Institutioncode::orderByDesc('institutionCode_id')->paginate(15);
        return view('pages.vocab-record-level-institution-code.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-institution-code.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['institutionCode_id'] ?? null)) {
                $data['institutionCode_id'] = (string) Str::uuid();
            }
            Institutioncode::create($data);
            return redirect()->route('vocab-record-level-institution-code.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Institutioncode $institutionCode)
    {
        return view('pages.vocab-record-level-institution-code.show', ['item' => $institutionCode]);
    }

    public function edit(Institutioncode $institutionCode)
    {
        return view('pages.vocab-record-level-institution-code.edit', ['item' => $institutionCode]);
    }

    public function update(Request $request, Institutioncode $institutionCode)
    {
        try {
            $data = $request->validate($this->rules($institutionCode));
            $institutionCode->update($data);
            return redirect()->route('vocab-record-level-institution-code.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Institutioncode $institutionCode)
    {
        try {
            $this->tx(fn () => $institutionCode->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }   

    protected function rules($institutionCode = null): array
    {
        return [
            'institutionCode_value' => [
                'required','string','max:50',
                Rule::unique('vocab_record_level_institutionCode','institutionCode_value')
                ->ignore($institutionCode?->institutionCode_id, 'institutionCode_id')
            ],
            'description' => ['required','string'],
        ];

    }

}
