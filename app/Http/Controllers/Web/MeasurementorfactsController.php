<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Measurementorfacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class MeasurementorfactsController extends Controller
{
    public function index()
    {
        $items = Measurementorfacts::orderByDesc('measurementID')->paginate(15);
        return view('pages.measurementorfacts.index', compact('items'));
    }

    public function create()
    {

        $occurrenceId = request('occurrence'); // viene del query string
        return view('pages.measurementorfacts.create', compact('occurrenceId'));

        /* return view('pages.measurementorfacts.create'); */
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['measurementID'] ?? null)) {
                $data['measurementID'] = (string) Str::uuid();
            }
            Measurementorfacts::create($data);
            return redirect()->route('occurrence.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show($id)
    {
        $item = Measurementorfacts::findOrFail($id);
        return view('pages.measurementorfacts.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Measurementorfacts::findOrFail($id);
        return view('pages.measurementorfacts.edit', compact('item'));
    }

    public function update(Request $request, Measurementorfacts $measurementorfacts )
    {
        try {
            $data = $request->validate($this->rules($measurementorfacts));
            $measurementorfacts->update($data);
            return redirect()->route('occurrence.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy($id)
    {
        $item = Measurementorfacts::findOrFail($id);
        try {
            DB::transaction(fn () => $item->delete());
            return redirect()->route('measurement-or-facts.index')->with('ok','Eliminado');
        } catch (\Throwable $e) {
            Log::error('Measurementorfacts destroy error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage());
        }
    }

    protected function rules($measurementorfacts = null): array
    {
        return [
            'measurementID'              => [$measurementorfacts ? 'sometimes' : 'nullable','string', Rule::unique('measurementorfacts','measurementID')->ignore($measurementorfacts?->measurementID,'measurementID')],
            'id_occ_bd'                  => ['required','string'],
            'measurementType'            => ['required','string'],
            'measurementValue'           => ['required','string'],
            'measurementAccuracy'        => ['required','string'],
            'measurementUnit'            => ['required','string'],
            'measurementDeterminedBy'    => ['required','string'],
            'measurementDeterminedDate'  => ['required','date'],
            'measurementMethod'          => ['required','string'],
            'measurementRemarks'         => ['required','string']
        ];
    }

}
