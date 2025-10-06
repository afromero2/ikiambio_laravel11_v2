<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblregistroslaboratorio;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TblRegistrosLaboratorioWebController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        /* $items = Tblregistroslaboratorio::orderByDesc('id')->paginate(15); */

        $items = TblRegistrosLaboratorio::with(['extraccion'])
            ->orderByDesc('idRegistrosLaboratorio')
            ->paginate(15);

        return view('pages.tbl-registros-laboratorio.index', compact('items'));
    }

    public function create()
    {
        $idExtracciones = request('idExtracciones'); // viene del query string
        return view('pages.tbl-registros-laboratorio.create', compact('idExtracciones'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['idRegistrosLaboratorio'] ?? null)) {
                $data['idRegistrosLaboratorio'] = (string) Str::uuid();
            }
            TblRegistrosLaboratorio::create($data);
            return redirect()->route('tbl-extractions.index')->with('ok', 'Registro laboratorio creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblregistroslaboratorio $idRegistrosLaboratorio)
    {
        return view('pages.tbl-registros-laboratorio.show', ['item' => $idRegistrosLaboratorio]);
    }

    public function edit(Tblregistroslaboratorio $idRegistrosLaboratorio)
    {
        return view('pages.tbl-registros-laboratorio.edit', ['item' => $idRegistrosLaboratorio]);
    }

    public function update(Request $request, Tblregistroslaboratorio $idRegistrosLaboratorio)
    {
        try {
            $data = $request->validate($this->rules($idRegistrosLaboratorio));
            $idRegistrosLaboratorio->update($data);
            return redirect()->route('tbl-extractions.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblregistroslaboratorio $idRegistrosLaboratorio)
    {
        try {
            $this->tx(fn () => $idRegistrosLaboratorio->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($idRegistrosLaboratorio = null): array
    {
        return [
            'idRegistrosLaboratorio'      => [$idRegistrosLaboratorio ? 'sometimes' : 'nullable','string', Rule::unique('TblRegistrosLaboratorio','idRegistrosLaboratorio')->ignore($idRegistrosLaboratorio,'idRegistrosLaboratorio')],
            'idFechaPCR'                  => ['required','string'],      // si aplicas FK: exists:TblFechaPCR,idFechaPCR
            'idExtracciones'              => ['required','string'],      // si aplicas FK: exists:TblExtracciones,idExtracciones
            'vol_ADN_PCR'                 => ['required','numeric'],
            'amplificationSuccess'        => ['nullable','boolean'],
            'amplificationSuccessDetails' => ['required','string'],
            'sampleDesignation'           => ['required','string'],
            'idPrimerF'                   => ['required','string'],      // exists:TblPrimersF,idPrimers
            'idPrimerR'                   => ['required','string'],      // exists:TblPrimersR,idPrimers
            'tecnologia_secuenciacion'    => ['required','string'],
            'consensusSequence'           => ['required','string'],
            'fechaSecuenciacion'          => ['required','date'],
            'sequencingStaff'             => ['required','string'],
            'ordenSecuenciacion'          => ['required','string'],
            'geneticAccessionNumber'      => ['required','string'],
            'geneticAccessionURI'         => ['required','string'],
        ];
    }

}
