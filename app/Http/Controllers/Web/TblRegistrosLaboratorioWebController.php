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
        
        $data = $request->validate([
            'idRegistrosLaboratorio' => ['nullable','string','max:255','unique:Tblregistroslaboratorio,idRegistrosLaboratorio'],
            'idFechaPCR'  => ['required','string','max:255'],
            'idExtracciones'         => ['required','string','max:255'],
            'vol_ADN_PCR'       => ['required','string','max:255'],
            'amplificationSuccess'   => ['nullable','string'],
            'amplificationSuccessDetails' => ['required','string','max:255'],
            'sampleDesignation'  => ['required','string'],
            'idPrimerF'      => ['required','string','max:255'],
            'idPrimerR'      => ['required','string','max:255'],
            'tecnologia_secuenciacion'  => ['required','string','max:255'],
            'consensusSequence'    => ['required','string','max:255'],
            'fechaSecuenciacion'      => ['required','date'],
            'sequencingStaff'      => ['required','string','max:255'],
            'ordenSecuenciacion'      => ['required','string','max:255'],
            'geneticAccessionNumber'      => ['required','string','max:255'],
            'geneticAccessionURI'      => ['required','string','max:255'],
        ]);

        try {
            $item = DB::transaction(function () use ($data) {
                if (empty($data['idRegistrosLaboratorio'])) {
                    $data['idRegistrosLaboratorio'] = (string) Str::uuid();
                }

                return Tblregistroslaboratorio::create($data);
            });

            return redirect()
                ->route('tbl-extractions.index', $item)
                ->with('ok', 'Registro laboratorio creado');

        } catch (\Throwable $e) {
            Log::error('Tblregistroslaboratorio store error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage())->withInput();
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
        $data = $request->validate([
            'idRegistrosLaboratorio' => ['nullable','string','max:255','unique:Tblregistroslaboratorio,idRegistrosLaboratorio'],
            'idFechaPCR'  => ['required','string','max:255'],
            'idExtracciones'         => ['required','string','max:255'],
            'vol_ADN_PCR'       => ['required','string','max:255'],
            'amplificationSuccess'   => ['required','string'],
            'amplificationSuccessDetails' => ['required','string','max:255'],
            'sampleDesignation'  => ['required','string'],
            'idPrimerF'      => ['required','string','max:255'],
            'idPrimerR'      => ['required','string','max:255'],
            'tecnologia_secuenciacion'  => ['required','string','max:255'],
            'consensusSequence'    => ['required','string','max:255'],
            'fechaSecuenciacion'      => ['required','date'],
            'sequencingStaff'      => ['required','string','max:255'],
            'ordenSecuenciacion'      => ['required','string','max:255'],
            'geneticAccessionNumber'      => ['required','string','max:255'],
            'geneticAccessionURI'      => ['required','string','max:255'],
        ]);


        try {
            $this->tx(fn () => $idRegistrosLaboratorio->update($data));
            return redirect()->route('tbl-extractions.index',$idRegistrosLaboratorio)->with('ok','Actualizado');
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
}
