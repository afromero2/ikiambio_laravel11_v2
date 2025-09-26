<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TblMultimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $data = $request->validate([
            // Si no envías idMultimedia, lo generamos
            'idMultimedia' => ['nullable','string','max:255','unique:TblMultimedia,idMultimedia'],
            'id_occ_bd'  => ['required','string','max:255'],
            'type'         => ['nullable','string','max:255'],
            'format'       => ['nullable','string','max:255'],
            'identifier'   => ['nullable','string'],
            'title'        => ['nullable','string','max:255'],
            'description'  => ['nullable','string'],
            'created'      => ['required','date'],
            'creator'      => ['required','string','max:255'],
            'contributor'  => ['nullable','string','max:255'],
            'publisher'    => ['nullable','string','max:255'],
            'license'      => ['nullable','string','max:255'],
        ]);

        try {
            $item = DB::transaction(function () use ($data) {
                if (empty($data['idMultimedia'])) {
                    $data['idMultimedia'] = (string) Str::uuid();
                }
                return TblMultimedia::create($data);
            });

            return redirect()
                ->route('tbl-multimedia.show', $item->idMultimedia)
                ->with('ok', 'Multimedia creado');

        } catch (\Throwable $e) {
            Log::error('TblMultimedia store error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $item = TblMultimedia::findOrFail($id);
        return view('pages.tblmultimedia.show', compact('item'));
    }

    public function edit($id)
    {
        $item = TblMultimedia::findOrFail($id);
        return view('pages.tblmultimedia.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = TblMultimedia::findOrFail($id);

        $data = $request->validate([
            'id_occ_bd'  => ['required','string','max:255'],
            'type'         => ['nullable','string','max:255'],
            'format'       => ['nullable','string','max:255'],
            'identifier'   => ['nullable','string'],
            'title'        => ['nullable','string','max:255'],
            'description'  => ['nullable','string'],
            'created'      => ['required','date'],
            'creator'      => ['required','string','max:255'],
            'contributor'  => ['nullable','string','max:255'],
            'publisher'    => ['nullable','string','max:255'],
            'license'      => ['nullable','string','max:255'],
        ]);

        try {
            DB::transaction(fn () => $item->update($data));
            /* return redirect()->route('occurrence.show', $item->idMultimedia)->with('ok','Actualizado'); */

            return redirect()->route('occurrence.index')->with('ok','Actualizado');

        } catch (\Throwable $e) {
            Log::error('TblMultimedia update error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $item = TblMultimedia::findOrFail($id);
        try {
            DB::transaction(fn () => $item->delete());
            return redirect()->route('tbl-multimedia.index')->with('ok','Eliminado');
        } catch (\Throwable $e) {
            Log::error('TblMultimedia destroy error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage());
        }
    }
}
