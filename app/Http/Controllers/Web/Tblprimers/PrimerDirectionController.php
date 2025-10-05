<?php

namespace App\Http\Controllers\Web\Tblprimers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Tblprimers\PrimerDirection;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PrimerDirectionController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = PrimerDirection::orderByDesc('id_primerdirection')->paginate(15);
        return view('pages.vocab-tblprimers-primer-direction.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-tblprimers-primer-direction.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['id_primerdirection'] ?? null)) {
                $data['id_primerdirection'] = (string) Str::uuid();
            }
            PrimerDirection::create($data);
            return redirect()->route('vocab-tblprimers-primer-direction.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(PrimerDirection $primerDirection)
    {
        return view('pages.vocab-tblprimers-primer-direction.show', ['item' => $primerDirection]);
    }

    public function edit(PrimerDirection $primerDirection)
    {
        return view('pages.vocab-tblprimers-primer-direction.edit', ['item' => $primerDirection]);
    }

    public function update(Request $request, PrimerDirection $primerDirection)
    {
        try {
            $data = $request->validate($this->rules($primerDirection));
            $primerDirection->update($data);
            return redirect()->route('vocab-tblprimers-primer-direction.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(PrimerDirection $primerDirection)
    {
        try {
            $this->tx(fn () => $primerDirection->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($primerDirection = null): array
    {
        return [
            'primerdirection_value' => [
                'required','string','max:20',
                Rule::unique('vocab_tblprimers_primerDirection','primerdirection_value')
                ->ignore($primerDirection?->id_primerdirection,'id_primerdirection')
            ],
            'description' => ['required','string'],
        ];
    }

}
