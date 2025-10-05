<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\OrganismQuantityType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrganismQuantityTypeController extends Controller
{
    use WrapsTransactions;

    public function index()                          
    {
        $items = OrganismQuantityType::orderByDesc('oqtype_id')->paginate(15);
        return view('pages.vocab-occurrence-organism-quantity-type.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-organism-quantity-type.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['disposition_id'] ?? null)) {
                $data['disposition_id'] = (string) Str::uuid();
            }
            OrganismQuantityType::create($data);
            return redirect()->route('vocab-occurrence-organism-quantity-type.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(OrganismQuantityType $organismQuantityType)
    {
        return view('pages.vocab-occurrence-organism-quantity-type.show', ['item' => $organismQuantityType]);
    }

    public function edit(OrganismQuantityType $organismQuantityType)
    {
        return view('pages.vocab-occurrence-organism-quantity-type.edit', ['item' => $organismQuantityType]);
    }

    public function update(Request $request, OrganismQuantityType $organismQuantityType)
    {
        try {
            $data = $request->validate($this->rules($organismQuantityType));
            $organismQuantityType->update($data);
            return redirect()->route('vocab-occurrence-organism-quantity-type.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(OrganismQuantityType $organismQuantityType)
    {
        try {
            $this->tx(fn () => $organismQuantityType->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($organismQuantityType = null): array
    {
        return [
            'oqtype_value' => [
                'required','string','max:30',
                Rule::unique('vocab_occurrence_organismQuantityType','oqtype_value')
                ->ignore($organismQuantityType?->oqtype_id,'oqtype_id')
            ],
            'description' => ['required','string']
        ];
    }

}
