<?php

namespace App\Http\Controllers\Web\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Location\Continent;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContinentController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Continent::orderByDesc('continent_id')->paginate(15);
        return view('pages.vocab-location-continent.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-location-continent.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['continent_id'] ?? null)) {
                $data['continent_id'] = (string) Str::uuid();
            }
            Continent::create($data);
            return redirect()->route('vocab-location-continent.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Continent $continent)
    {
        return view('pages.vocab-location-continent.show', ['item' => $continent]);
    }

    public function edit(Continent $continent)
    {
        return view('pages.vocab-location-continent.edit', ['item' => $continent]);
    }

    public function update(Request $request, Continent $continent)
    {
        try {
            $data = $request->validate($this->rules($continent));
            $continent->update($data);
            return redirect()->route('vocab-location-continent.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Continent $continent)
    {
        try {
            $this->tx(fn () => $continent->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($continent = null): array
    {
        return [
            'continent_value' => [
                'required','string','max:50',
                Rule::unique('vocab_location_continent','continent_value')
                ->ignore($continent?->continent_id,'continent_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
