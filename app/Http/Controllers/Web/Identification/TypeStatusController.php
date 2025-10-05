<?php

namespace App\Http\Controllers\Web\Identification;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Identification\TypeStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TypeStatusController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = TypeStatus::orderByDesc('vocab_identification_typeStatus_id')->paginate(15);
        return view('pages.vocab-identification-type-status.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-identification-type-status.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['vocab_identification_typeStatus_id'] ?? null)) {
                $data['vocab_identification_typeStatus_id'] = (string) Str::uuid();
            }
            TypeStatus::create($data);
            return redirect()->route('vocab-identification-type-status.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
	    }    
    }

    public function show(TypeStatus $typeStatus)
    {
        return view('pages.vocab-identification-type-status.show', ['item' => $typeStatus]);
    }

    public function edit(TypeStatus $typeStatus)
    {
        return view('pages.vocab-identification-type-status.edit', ['item' => $typeStatus]);
    }

    public function update(Request $request, TypeStatus $typeStatus)
    {
        try {
            $data = $request->validate($this->rules($typeStatus));
            $typeStatus->update($data);
            return back()->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(TypeStatus $typeStatus)
    {
        try {
            $this->tx(fn () => $typeStatus->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($typeStatus = null): array
    {
        return [
            'typeStatus_value' => [
                'required','string','max:50', Rule::unique('vocab_identification_typeStatus','typeStatus_value')
                ->ignore($typeStatus?->vocab_identification_typeStatus_id,'vocab_identification_typeStatus_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
