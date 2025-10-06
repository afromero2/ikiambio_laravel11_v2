<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\VocabTblprimersPrimerdirection;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VocabTblprimersPrimerdirectionController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = VocabTblprimersPrimerdirection::orderByDesc('id')->paginate(15);
        return view('pages.voca\1-\\1-\2rimerdirection.index', compact('items'));
    }

    public function create()
    {
        return view('pages.voca\1-\\1-\2rimerdirection.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => VocabTblprimersPrimerdirection::create($data));
            return redirect()->route('voca\1-\\1-\2rimerdirection.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        return view('pages.voca\1-\\1-\2rimerdirection.show', ['item' => $vocabTblprimersPrimerdirection]);
    }

    public function edit(VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        return view('pages.voca\1-\\1-\2rimerdirection.edit', ['item' => $vocabTblprimersPrimerdirection]);
    }

    public function update(Request $request, VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $vocabTblprimersPrimerdirection->update($data));
            return redirect()->route('voca\1-\\1-\2rimerdirection.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        try {
            $this->tx(fn () => $vocabTblprimersPrimerdirection->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
