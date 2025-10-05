<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\Sex;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SexController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Sex::orderByDesc('sex_id')->paginate(15);
        return view('pages.vocab-occurrence-sex.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-sex.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['sex_id'] ?? null)) {
                $data['sex_id'] = (string) Str::uuid();
            }
            Sex::create($data);
            return redirect()->route('vocab-occurrence-sex.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Sex $sex)
    {
        return view('pages.vocab-occurrence-sex.show', ['item' => $sex]);
    }

    public function edit(Sex $sex)
    {
        return view('pages.vocab-occurrence-sex.edit', ['item' => $sex]);
    }

    public function update(Request $request, Sex $sex)
    {
        try {
            $data = $request->validate($this->rules($sex));
            $sex->update($data);
            return redirect()->route('vocab-occurrence-sex.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Sex $sex)
    {
        try {
            $this->tx(fn () => $sex->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    
    protected function rules($sex = null): array
    {
        return [
            'sex_value' => [
                'required','string','max:30',
                Rule::unique('vocab_occurrence_sex','sex_value')
                ->ignore($sex?->sex_id,'sex_id')
            ],
            'description' => ['required','string']
        ];
    }

}
