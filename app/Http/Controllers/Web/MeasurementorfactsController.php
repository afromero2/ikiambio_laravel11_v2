<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Measurementorfacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $data = $request->validate([
            'measurementID'                => ['nullable','string','max:255','unique:measurementorfacts,measurementID'],
            'id_occ_bd'                    => ['nullable','string','max:255'], // ajusta si es int en tu esquema
            'measurementType'              => ['nullable','string','max:255'],
            'measurementValue'             => ['nullable','string','max:255'],
            'measurementAccuracy'          => ['nullable','string','max:255'],
            'measurementUnit'              => ['nullable','string','max:255'],
            'measurementDeterminedBy'      => ['nullable','string','max:255'],
            'measurementDeterminedDate'    => ['nullable','date'],
            'measurementMethod'            => ['nullable','string'],
            'measurementRemarks'           => ['nullable','string'],
        ]);

        try {
            $item = DB::transaction(function () use ($data) {
                if (empty($data['measurementID'])) {
                    $data['measurementID'] = (string) Str::uuid();
                }
                return Measurementorfacts::create($data);
            });

            return redirect()
                ->route('measurement-or-facts.show', $item->measurementID)
                ->with('ok', 'Measurement/Fact creado');

        } catch (\Throwable $e) {
            Log::error('Measurementorfacts store error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage())->withInput();
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

    public function update(Request $request, $id)
    {
        $item = Measurementorfacts::findOrFail($id);

        $data = $request->validate([
            'id_occ_bd'                    => ['nullable','string','max:255'],
            'measurementType'              => ['nullable','string','max:255'],
            'measurementValue'             => ['nullable','string','max:255'],
            'measurementAccuracy'          => ['nullable','string','max:255'],
            'measurementUnit'              => ['nullable','string','max:255'],
            'measurementDeterminedBy'      => ['nullable','string','max:255'],
            'measurementDeterminedDate'    => ['nullable','date'],
            'measurementMethod'            => ['nullable','string'],
            'measurementRemarks'           => ['nullable','string'],
        ]);

        try {
            DB::transaction(fn () => $item->update($data));
            /* return redirect()->route('occurrence.index', $item->measurementID)->with('ok','Actualizado'); */
            return redirect()->route('occurrence.index')->with('ok','Actualizado');
        } catch (\Throwable $e) {
            Log::error('Measurementorfacts update error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage())->withInput();
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
}
