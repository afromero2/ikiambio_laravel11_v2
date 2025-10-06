<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblprimersr;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TblprimersrController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblprimersr::orderByDesc('idPrimersr')->paginate(15);
        return view('pages.tblprimersr.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblprimersr.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['idPrimersr'] ?? null)) {
                $data['idPrimersr'] = (string) Str::uuid();
            }
            Tblprimersr::create($data);
            return redirect()->route('tbl-primers-r.index')->with('ok', 'Creado');
        } catch (QueryException $e) {
            /* return back()->withErrors('No se pudo crear.')->withInput(); */
            return $e;
        }
    }

    public function show(Tblprimersr $tblprimersr)
    {
        return view('pages.tblprimersr.show', ['item' => $tblprimersr]);
    }

    public function edit(Tblprimersr $tblprimersr)
    {
        return view('pages.tblprimersr.edit', ['item' => $tblprimersr]);
    }

    public function update(Request $request, Tblprimersr $tblprimersr)
    {
        try {
            $data = $request->validate($this->rules($tblprimersr));
            $tblprimersr->update($data);
            return redirect()->route('tbl-primers-r.index')->with('ok', 'Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblprimersr $tblprimersr)
    {
        try {
            $this->tx(fn () => $tblprimersr->delete());
            return back()->with('ok', 'Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($tblprimersr = null): array
    {
        return [
            'idPrimersr'               => [$tblprimersr ? 'sometimes' : 'nullable','string', Rule::unique('TblPrimersR','idPrimersr')->ignore($tblprimersr?->idPrimersr,'idPrimersr')],
            'genAbrev'                => ['required','string'],
            'genName'                 => ['required','string'],
            'primerName'              => ['required','string'],
            'primerSequence'          => ['required','string'],
            'primerReferenceCitation' => ['required','string'],
            'id_primerDirection'      => ['required','string'],
            'grupo_Taxonomico'        => ['required','string'],
            'region'                  => ['required','string'],
            'tecnologia'              => ['required','string'],
            'proyecto_Tesis'          => ['required','string'],
            'longitud_Primer'         => ['required','integer'],
            'Longitud_amplicon'       => ['required','integer'],
            'gc'                      => ['required','numeric'],
            'dnaMeltingPoint'         => ['required','numeric'],
            'annealing_Temperature'   => ['required','numeric'],
            'primerStaff'             => ['required','string'],
            'fecha_orden'             => ['required','date'],
            'proveedor'               => ['required','string'],
        ];
    }

}
