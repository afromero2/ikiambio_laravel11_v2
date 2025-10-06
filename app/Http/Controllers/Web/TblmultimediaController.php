<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TblMultimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class TblmultimediaController extends Controller
{
    public function index()
    {
        $items = TblMultimedia::orderByDesc('idMultimedia')->paginate(15);
        return view('pages.tblmultimedia.index', compact('items'));
    }

    public function create()
    {

        $occurrenceId = request('occurrence'); // viene del query string
        return view('pages.tblmultimedia.create', compact('occurrenceId'));

        /* return view('pages.tblmultimedia.create'); */
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['idMultimedia'] ?? null)) {
                $data['idMultimedia'] = (string) Str::uuid();
            }
            TblMultimedia::create($data);
            return redirect()->route('occurrence.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show($multimedia)
    {
        $item = TblMultimedia::findOrFail($multimedia);
        return view('pages.tblmultimedia.show', compact('item'));
    }

    public function edit($multimedia)
    {
        $item = TblMultimedia::findOrFail($multimedia);
        return view('pages.tblmultimedia.edit', compact('item'));
    }

    public function update(Request $request, TblMultimedia $multimedia)
    {
        try {
            $data = $request->validate($this->rules($multimedia));
            $multimedia->update($data);
            return redirect()->route('occurrence.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy($multimedia)
    {
        $item = TblMultimedia::findOrFail($multimedia);
        try {
            DB::transaction(fn () => $item->delete());
            return redirect()->route('occurrence.index')->with('ok','Eliminado');
        } catch (\Throwable $e) {
            Log::error('TblMultimedia destroy error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage());
        }
    }

    protected function rules($multimedia = null): array
    {
        return [
            'idMultimedia' => [$multimedia ? 'sometimes' : 'nullable','string', Rule::unique('TblMultimedia','idMultimedia')->ignore($multimedia?->idMultimedia,'idMultimedia')],
            'id_occ_bd'    => ['required','string'], // si aplicas FK: exists:occurrence,id_occ_bd
            'type'         => ['required','string'],
            'format'       => ['required','string'],
            'identifier'   => ['required','string'],
            'title'        => ['required','string'],
            'description'  => ['required','string'],
            'created'      => ['required','date'],
            'creator'      => ['required','string'],
            'contributor'  => ['required','string'],
            'publisher'    => ['required','string'],
            'license'      => ['required','string']
        ];
    }

}
