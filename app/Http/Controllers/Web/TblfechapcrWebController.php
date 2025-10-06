<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblfechapcr;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TblfechapcrWebController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblfechapcr::orderByDesc('idFechaPCR')->paginate(15);
        return view('pages.tblfechapcr.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblfechapcr.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['idFechaPCR'] ?? null)) {
                $data['idFechaPCR'] = (string) Str::uuid();
            }
            Tblfechapcr::create($data);
            return redirect()->route('tbl-fecha-pcr.index')->with('ok','Creado');
        } catch (QueryException $e) {
            /* return back()->withErrors('No se pudo crear.')->withInput(); */
            return $e;
        }
    }

    public function show(Tblfechapcr $fechaPcr)
    {
        return view('pages.tblfechapcr.show', ['item' => $fechaPcr]);
    }

    public function edit(Tblfechapcr $fechaPcr)
    {
        return view('pages.tblfechapcr.edit', ['item' => $fechaPcr]);
    }

    public function update(Request $request, Tblfechapcr $fechaPcr)
    {
        try {
            $data = $request->validate($this->rules($fechaPcr));
            $fechaPcr->update($data);
            return redirect()->route('tbl-fecha-pcr.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblfechapcr $fechaPcr)
    {
        try {
            $this->tx(fn () => $fechaPcr->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($fechaPcr = null): array
    {
        return [
            'idFechaPCR'            => [$fechaPcr ? 'sometimes' : 'nullable','string', Rule::unique('TblFechaPCR','idFechaPCR')->ignore($fechaPcr ?->idFechaPCR,'idFechaPCR')],
            'amplificationDate'     => ['required','date'],
            'amplificationMethod'   => ['required','string'],
            'lugar_process'         => ['required','string'],
            'amplificationStaff'    => ['required','string'],
            'num_reacciones'        => ['required','integer'],
            'volumen_finalRx'       => ['required','numeric'],
            'masterMix'             => ['required','numeric'],
            'clh20'                 => ['required','numeric'],
            'buffer'                => ['required','numeric'],
            'bsa'                   => ['required','numeric'],
            'mgcl'                  => ['required','numeric'],
            'dntp'                  => ['required','numeric'],
            'primer_F'              => ['required','numeric'],
            'primer_R'              => ['required','numeric'],
            'taq'                   => ['required','integer'],
            'adn'                   => ['required','integer'],
            'equipo_PCR'            => ['required','string'],
            'pre_c'                 => ['required','integer'],
            'pretiempo'             => ['required','integer'],
            'pcr1_c'                => ['required','integer'],
            'pcr1tiempo'            => ['required','integer'],
            'pcr2_c'                => ['required','integer'],
            'pcr2tiempo'            => ['required','integer'],
            'pcr3_c'                => ['required','integer'],
            'pcr3tiempo'            => ['required','integer'],
            'post_c'                => ['required','integer'],
            'post_tiempo'           => ['required','integer'],
            'final_c'               => ['required','integer'],
            'ciclos'                => ['required','integer'],
            'imagenPCRAccessionURI' => ['required','string'],
            'imagenPCR'             => ['required','string']
        ];
    }


}
