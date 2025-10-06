<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Identification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class IdentificationWebController extends Controller
{
    public function index()
    {
        $items = Identification::orderBy('identificationID')->paginate(15);
        return view('pages.identification.index', compact('items'));
    }

    public function show(Identification $identification)
    {
        $identification->load(['typeStatusRef','verificationStatusRef']);
        return view('pages.identification.show', ['item' => $identification]);
    }

    public function create()
    {
        return view('pages.identification.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['identificationID'] ?? null)) {
                $data['identificationID'] = (string) Str::uuid();
            }
            Identification::create($data);
            return redirect()->route('identification.index')->with('ok','Creado');
        } catch (QueryException $e) {
            /* return back()->withErrors('No se pudo crear.')->withInput(); */
            return $e;
        }
    }

    public function edit(Identification $identification)
    {
        return view('pages.identification.edit', ['item' => $identification]);
    }

    public function update(Request $request, Identification $identification)
    {
        try {
            $data = $request->validate($this->rules($identification));
            $identification->update($data);
            return redirect()->route('identification.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Identification $identification)
    {
        DB::transaction(fn()=> $identification->delete());
        return back()->with('ok','Eliminado');
    }

    protected function rules($identification = null): array
    {
        return [
            'identificationID'             => [$identification ? 'sometimes' : 'nullable','string','max:100', Rule::unique('identification','identificationID')->ignore($identification?->identificationID,'identificationID')],
            'identificationQualifier'      => ['required','string','max:100'],
            'typeStatus'                   => ['required','integer'],
            'identifiedBy'                 => ['required','string','max:255'],
            'dateIdentified'               => ['required','date'],
            'identificationVerificationStatus' => ['required','integer'],
            'identificationRemarks'        => ['required','string'],
        ];
    }

}
