<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\ReproductiveCondition;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ReproductiveConditionController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = ReproductiveCondition::orderByDesc('vocab_occurrence_reproductiveCondition')->paginate(15);
        return view('pages.vocab-occurrence-reproductive-condition.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-reproductive-condition.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['reprocond_id'] ?? null)) {
                $data['reprocond_id'] = (string) Str::uuid();
            }
            ReproductiveCondition::create($data);
            return redirect()->route('vocab-occurrence-reproductive-condition.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(ReproductiveCondition $reproductiveCondition)
    {
        return view('pages.vocab-occurrence-reproductive-condition.show', ['item' => $reproductiveCondition]);
    }

    public function edit(ReproductiveCondition $reproductiveCondition)
    {
        return view('pages.vocab-occurrence-reproductive-condition.edit', ['item' => $reproductiveCondition]);
    }

    public function update(Request $request, ReproductiveCondition $reproductiveCondition)
    {
        try {
            $data = $request->validate($this->rules($reproductiveCondition));
            $reproductiveCondition->update($data);
            return redirect()->route('vocab-occurrence-reproductive-condition.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(ReproductiveCondition $reproductiveCondition)
    {
        try {
            $this->tx(fn () => $reproductiveCondition->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($reproductiveCondition = null): array
    {
        return [
            'reprocond_value' => [
                'required','string','max:40',
                Rule::unique('vocab_occurrence_reproductiveCondition','reprocond_value')
                ->ignore($reproductiveCondition?->reprocond_id,'reprocond_id')
            ],
            'description' => ['required','string']
        ];
    }

}
