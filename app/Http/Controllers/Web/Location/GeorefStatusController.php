<?php

namespace App\Http\Controllers\Web\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Location\GeorefStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GeorefStatusController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = GeorefStatus::orderByDesc('georef_status_id')->paginate(15);
        return view('pages.vocab-location-georef-status.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-location-georef-status.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['georef_status_id'] ?? null)) {
                $data['georef_status_id'] = (string) Str::uuid();
            }
            GeorefStatus::create($data);
            return redirect()->route('vocab-location-georef-status.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(GeorefStatus $georefStatus)
    {
        return view('pages.vocab-location-georef-status.show', ['item' => $georefStatus]);
    }

    public function edit(GeorefStatus $georefStatus)
    {
        return view('pages.vocab-location-georef-status.edit', ['item' => $georefStatus]);
    }

    public function update(Request $request, GeorefStatus $georefStatus)
    {
        try {
            $data = $request->validate($this->rules($georefStatus));
            $georefStatus->update($data);
            return redirect()->route('vocab-location-georef-status.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
        
        $data = $request->all();
    }

    public function destroy(GeorefStatus $georefStatus)
    {
        try {
            $this->tx(fn () => $georefStatus->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($georefStatus = null): array
    {
        return [
            'georef_status_value' => [
                'required','string','max:80',
                Rule::unique('vocab_location_georef_status','georef_status_value')
                ->ignore($georefStatus?->georef_status_id,'georef_status_id')
            ],
            'description' => ['required','string'],
        ];
    }


}
