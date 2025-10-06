<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\IkiambioUser;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class IkiambioUserController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $users = IkiambioUser::orderByDesc('id')->paginate(15);
        return view('pages.ikiambio-users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.ikiambio-users.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => IkiambioUser::create($data));
            return redirect()->route('ikiambio-users.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(IkiambioUser $ikiambioUser)
    {
        return view('pages.ikiambio-users.show', ['user' => $ikiambioUser]);
    }

    public function edit(IkiambioUser $ikiambioUser)
    {
        return view('pages.ikiambio-users.edit', ['user' => $ikiambioUser]);
    }

    public function update(Request $request, IkiambioUser $ikiambioUser)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $ikiambioUser->update($data));
            return redirect()->route('ikiambio-users.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(IkiambioUser $ikiambioUser)
    {
        try {
            $this->tx(fn () => $ikiambioUser->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
