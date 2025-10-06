<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Http\Controllers\Controller;
use App\Models\Tblextractions;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TblextractionsController extends Controller
{
    use WrapsTransactions;

    public function index()
    {   
        $items = Tblextractions::with([
            'regLaboratorio' => function ($q) {
                $q->select([
                    'idExtracciones',
                    'idRegistrosLaboratorio', 
                    'vol_ADN_PCR',
                    'amplificationSuccess',
                    'amplificationSuccessDetails',
                    'sequencingStaff'
                ])
                ->orderByDesc('idRegistrosLaboratorio')
                ->orderBy('sequencingStaff');
            },
        ])
        ->withCount('regLaboratorio')        // $location->events_count disponible en la vista
        ->orderByDesc('idExtracciones')  // más útil ver las últimas primero
        ->paginate(15);    

        return view('pages.tblextractions.index', compact('items'));
    }

    public function create()
    {
        $occurrenceId = request('occurrence'); // viene del query string
        return view('pages.tblextractions.create', compact('occurrenceId'));

        /* return view('pages.tblextractions.create'); */
    }

    public function store(Request $request)
    {
       try {
            $data = $request->validate($this->rules());
            if (empty($data['disposition_id'] ?? null)) {
                $data['disposition_id'] = (string) Str::uuid();
            }
            Tblextractions::create($data);
            return redirect()->route('occurrence.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblextractions $tblextractions)
    {
        return view('pages.tblextractions.show', ['item' => $tblextractions]);
    }

    public function edit(Tblextractions $tblextractions)
    {
        return view('pages.tblextractions.edit', ['item' => $tblextractions]);
    }

    public function update(Request $request, Tblextractions $tblextractions)
    {
        try {
            $data = $request->validate($this->rules($tblextractions));
            $tblextractions->update($data);
            return redirect()->route('occurrence.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblextractions $tblextractions)
    {
        try {
            $this->tx(fn () => $tblextractions->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($tblextractions = null): array
    {
        return [
            'idExtracciones'                     => [$tblextractions ? 'sometimes' : 'nullable','string', Rule::unique('TblExtracciones','idExtracciones')->ignore($tblextractions?->idExtracciones,'idExtracciones')],
            'id_occ_bd'                          => ['required','string'], // si usas FK real: 'exists:occurrence,id_occ_bd'
            'materialSampleType'                 => ['required','string'],
            'idRegistros'                        => ['required','string'],
            'fechaExtraccion'                    => ['required','date'],
            'purificationMethod'                 => ['required','string'],
            'methodDeterminationConcentrationAndRatios' => ['required','string'],
            'adn_enSTOCK'                        => ['nullable','boolean'],
            'volume'                             => ['required','numeric'],
            'volumeUnit'                         => ['required','string'],
            'concentration'                      => ['required','numeric'],
            'concentrationUnit'                  => ['required','string'],
            'ratioOfAbsorbance260_280'           => ['required','numeric'],
            'ratioOfAbsorbance260_230'           => ['required','numeric'],
            'preservationType'                   => ['required','string'],
            'preservationTemperature'            => ['required','string'],
            'preservationDateBegin'              => ['required','date'],
            'quality'                            => ['required','string'],
            'qualityCheckDate'                   => ['required','date'],
            'sieving'                            => ['required','string'],
            'codigoMuestraBiobanco'              => ['required','string'],
            'codigoADNBiobanco'                  => ['required','string'],
            'codigoGermoplasmaBiobanco'          => ['required','string'],
            'extractionStaff'                    => ['required','string'],
            'qualityRemarks'                     => ['required','string']
        ];

    }

    private function validateData(Request $request, bool $isUpdate = false, ?Tblextractions $current = null): array
    {
        // Para update usamos 'sometimes' (solo valida lo enviado)
        $req = $isUpdate ? 'sometimes' : 'nullable';

        return $request->validate([
            // Si no envías idExtracciones, el modelo puede generarlo en booted()
            'idExtracciones' => [$req, 'string', 'max:255'],

            // Si id_occ_bd referencia occurrence.id_occ_bd (varchar):
            'id_occ_bd'      => [$req, 'string', 'max:255'], // agrega Rule::exists si quieres forzar FK

            'materialSampleType' => [$req, 'string', 'max:255'],
            'idRegistros'        => [$req, 'string', 'max:255'],

            'fechaExtraccion'    => [$req, 'date'],

            'purificationMethod' => [$req, 'string'],
            'methodDeterminationConcentrationAndRatios' => [$req, 'string'],

            // Boolean en Postgres
            'adn_enSTOCK'        => [$req, 'boolean'],

            // Numéricos / decimales
            'volume'                   => [$req, 'numeric'],
            'volumeUnit'               => [$req, 'string', 'max:50'],
            'concentration'            => [$req, 'numeric'],
            'concentrationUnit'        => [$req, 'string', 'max:50'],
            'ratioOfAbsorbance260_280' => [$req, 'numeric'],
            'ratioOfAbsorbance260_230' => [$req, 'numeric'],

            'preservationType'        => [$req, 'string', 'max:255'],
            'preservationTemperature' => [$req, 'string', 'max:255'],
            'preservationDateBegin'   => [$req, 'date'],

            'quality'                 => [$req, 'string', 'max:255'],
            'qualityCheckDate'        => [$req, 'date'],
            'sieving'                 => [$req, 'string', 'max:255'],
            'codigoMuestraBiobanco'   => [$req, 'string', 'max:255'],
            'codigoADNBiobanco'       => [$req, 'string', 'max:255'],
            'codigoGermoplasmaBiobanco'=> [$req, 'string', 'max:255'],
            'extractionStaff'         => [$req, 'string', 'max:255'],
            'qualityRemarks'          => [$req, 'string'],
        ]);
    }

}
