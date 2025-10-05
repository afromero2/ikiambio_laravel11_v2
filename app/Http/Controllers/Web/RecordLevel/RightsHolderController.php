<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Rightsholder;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RightsHolderController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Rightsholder::orderByDesc('rightsHolder_id')->paginate(15);
        return view('pages.vocab-record-level-rights-holder.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-rights-holder.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['rightsHolder_id'] ?? null)) {
                $data['rightsHolder_id'] = (string) Str::uuid();
            }
            Rightsholder::create($data);
            return redirect()->route('vocab-record-level-rights-holder.index')->with('ok','Creado');
        } catch (QueryException $e) {
            /* return back()->withErrors('No se pudo actualizar.')->withInput(); */
            return $e;
        }
    }

    public function show(Rightsholder $rightsHolder)
    {
        return view('pages.vocab-record-level-rights-holder.show', ['item' => $rightsHolder]);
    }

    public function edit(Rightsholder $rightsHolder)
    {
        return view('pages.vocab-record-level-rights-holder.edit', ['item' => $rightsHolder]);
    }

    public function update(Request $request, Rightsholder $rightsHolder)
    {
        try {
            $data = $request->validate($this->rules($rightsHolder));
            $rightsHolder->update($data);
            return redirect()->route('vocab-record-level-rights-holder.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Rightsholder $rightsHolder)
    {
        try {
            $this->tx(fn () => $rightsHolder->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($rightsHolder = null): array
    {   
       /*  return [
            'rightsHolder_value' => [
                'required','string','max:150',
                Rule::unique('vocab-record-level-rightsholder','rightsHolder_value')
                ->ignore($rightsHolder?->rightsHolder_id, 'rightsHolder_id')
            ],
            'description'  => ['required','string'],
        ]; */

        return [
            'rightsHolder_value' => ['required','string','max:150'],
            'description'        => ['required','string'],
        ];
    }

}
