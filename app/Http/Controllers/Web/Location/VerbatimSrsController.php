<?php

namespace App\Http\Controllers\Web\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Location\VerbatimSrs;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VerbatimSrsController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = VerbatimSrs::orderByDesc('verbatimSRS_id')->paginate(15);
        return view('pages.vocab-location-verbatim-srs.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-location-verbatim-srs.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['verbatimSRS_id'] ?? null)) {
                $data['verbatimSRS_id'] = (string) Str::uuid();
            }
            VerbatimSrs::create($data);
             return redirect()->route('vocab-location-verbatim-srs.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(VerbatimSrs $verbatimSrs)
    {
        return view('pages.vocab-location-verbatim-srs.show', ['item' => $verbatimSrs]);
    }

    public function edit(VerbatimSrs $verbatimSrs)
    {
        return view('pages.vocab-location-verbatim-srs.edit', ['item' => $verbatimSrs]);
    }

    public function update(Request $request, VerbatimSrs $verbatimSrs)
    {
        try {
            $data = $request->validate($this->rules($verbatimSrs));
            $verbatimSrs->update($data);
            return redirect()->route('vocab-location-verbatim-srs.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(VerbatimSrs $verbatimSrs)
    {
        try {
            $this->tx(fn () => $verbatimSrs->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($verbatimSrs = null): array
    {
        return [
            'verbatimSRS_value' => [
                'required','string','max:50',
                Rule::unique('vocab_location_verbatimSRS','verbatimSRS_value')
                ->ignore($verbatimSrs?->verbatimSRS_id,'verbatimSRS_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
