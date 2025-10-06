<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblprimersf;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TblprimersfController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblprimersf::orderByDesc('idPrimersf')->paginate(15);
        return view('pages.tblprimersf.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblprimersf.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['idPrimersf'] ?? null)) {
                $data['idPrimersf'] = (string) Str::uuid();
            }
            Tblprimersf::create($data);
            return redirect()->route('tbl-primers-f.index')->with('ok', 'Creado');
        } catch (QueryException $e) {
            /* return back()->withErrors('No se pudo crear.')->withInput(); */
            return $e;
        }
    }

    public function show(Tblprimersf $tblprimersf)
    {
        return view('pages.tblprimersf.show', ['item' => $tblprimersf]);
    }

    public function edit(Tblprimersf $tblprimersf)
    {
        return view('pages.tblprimersf.edit', ['item' => $tblprimersf]);
    }

    public function update(Request $request, Tblprimersf $tblprimersf)
    {
        try {
            $data = $request->validate($this->rules($tblprimersf));
            $tblprimersf->update($data);
            return redirect()->route('tbl-primers-f.index')->with('ok', 'Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblprimersf $tblprimersf)
    {
        try {
            $this->tx(fn () => $tblprimersf->delete());
            return back()->with('ok', 'Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($tblprimersf = null): array
    {
        return [
            'idPrimersf'                  => [$tblprimersf ? 'sometimes' : 'nullable','string', Rule::unique('TblPrimersF','idPrimersf')->ignore($tblprimersf?->idPrimersf,'idPrimersf')],
            'genAbrev'                   => ['required','string'],
            'genName'                    => ['required','string'],
            'primerName'                 => ['required','string'],
            'primerSequence'             => ['required','string'],
            'primerReferenceCitation'    => ['required','string'],
            'id_primerDirection'         => ['required','string'],
            'grupo_Taxonomico'           => ['required','string'],
            'region'                     => ['required','string'],
            'tecnologia'                 => ['required','string'],
            'proyecto_Tesis'             => ['required','string'],
            'longitud_Primer'            => ['required','integer'],
            'Longitud_amplicon'          => ['required','integer'],
            'gc'                         => ['required','numeric'],
            'dnaMeltingPoint'            => ['required','numeric'],
            'annealing_Temperature'      => ['required','numeric'],
            'primerStaff'                => ['required','string'],
            'fecha_orden'                => ['required','date'],
            'proveedor'                  => ['required','string']
        ];
    }
}
