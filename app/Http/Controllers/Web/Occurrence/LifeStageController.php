<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\LifeStage;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LifeStageController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = LifeStage::orderByDesc('lifestage_id')->paginate(15);
        return view('pages.vocab-occurrence-life-stage.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-life-stage.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['lifestage_id'] ?? null)) {
                $data['lifestage_id'] = (string) Str::uuid();
            }
            LifeStage::create($data);
            return redirect()->route('vocab-occurrence-life-stage.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(LifeStage $lifeStage)
    {
        return view('pages.vocab-occurrence-life-stage.show', ['item' => $lifeStage]);
    }

    public function edit(LifeStage $lifeStage)
    {
        return view('pages.vocab-occurrence-life-stage.edit', ['item' => $lifeStage]);
    }

    public function update(Request $request, LifeStage $lifeStage)
    {
        try {
            $data = $request->validate($this->rules($lifeStage));
            $lifeStage->update($data);
            return redirect()->route('vocab-occurrence-life-stage.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(LifeStage $lifeStage)
    {
        try {
            $this->tx(fn () => $lifeStage->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($lifeStage = null): array
    {
        return [
            'lifestage_value' => [
                'required','string','max:40',
                Rule::unique('vocab_occurrence_lifeStage','lifestage_value')
                ->ignore($lifeStage?->lifestage_id,'lifestage_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
