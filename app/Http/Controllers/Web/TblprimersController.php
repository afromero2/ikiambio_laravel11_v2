<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblprimers;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TblprimersController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblprimers::orderByDesc('id')->paginate(15);
        return view('pages.tblprimers.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblprimers.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Tblprimers::create($data));
            return redirect()->route('tblprimers.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblprimers $tblprimers)
    {
        return view('pages.tblprimers.show', ['item' => $tblprimers]);
    }

    public function edit(Tblprimers $tblprimers)
    {
        return view('pages.tblprimers.edit', ['item' => $tblprimers]);
    }

    public function update(Request $request, Tblprimers $tblprimers)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $tblprimers->update($data));
            return redirect()->route('tblprimers.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblprimers $tblprimers)
    {
        try {
            $this->tx(fn () => $tblprimers->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
