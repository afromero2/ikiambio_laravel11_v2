<?php

namespace App\Http\Controllers\Web\Identification;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Identification\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class VerificationStatusController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = VerificationStatus::orderByDesc('vocab_identification_verificationStatus_id')->paginate(15);
        return view('pages.vocab-identification-verification-status.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-identification-verification-status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => VerificationStatus::create($data));
            return redirect()->route('vocab-identification-verification-status.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(VerificationStatus $verificationStatus)
    {
        return view('pages.vocab-identification-verification-status.show', ['item' => $verificationStatus]);
    }

    public function edit(VerificationStatus $verificationStatus)
    {
        return view('pages.vocab-identification-verification-status.edit', ['item' => $verificationStatus]);
    }

    public function update(Request $request, VerificationStatus $verificationStatus)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $verificationStatus->update($data));
            return redirect()->route('vocab-identification-verification-status.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(VerificationStatus $verificationStatus)
    {
        try {
            $this->tx(fn () => $verificationStatus->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
