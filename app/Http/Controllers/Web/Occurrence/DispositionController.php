<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\Disposition;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DispositionController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Disposition::orderByDesc('disposition_id')->paginate(15);
        return view('pages.vocab-occurrence-disposition.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-disposition.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['disposition_id'] ?? null)) {
                $data['disposition_id'] = (string) Str::uuid();
            }
            Disposition::create($data);
            return redirect()->route('vocab-occurrence-disposition.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Disposition $disposition)
    {
        return view('pages.vocab-occurrence-disposition.show', ['item' => $disposition]);
    }

    public function edit(Disposition $disposition)
    {
        return view('pages.vocab-occurrence-disposition.edit', ['item' => $disposition]);
    }

    public function update(Request $request, Disposition $disposition)
    {
        try {
            $data = $request->validate($this->rules($disposition));
            $disposition->update($data);
            return redirect()->route('vocab-occurrence-disposition.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Disposition $disposition)
    {
        try {
            $this->tx(fn () => $disposition->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($disposition = null): array
    {
        return [
            'disposition_value' => [
                'required','string','max:40',
                Rule::unique('vocab_occurrence_disposition','disposition_value')
                ->ignore($disposition?->disposition_id,'disposition_id')
            ],
            'description' => ['required','string']
        ];
    }

}
