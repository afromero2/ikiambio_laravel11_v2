<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Accessrights;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccessRightsController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Accessrights::orderByDesc('accessrights_id')->paginate(15);
        return view('pages.vocab-record-level-access-rights.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-access-rights.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['accessrights_id'] ?? null)) {
                $data['accessrights_id'] = (string) Str::uuid();
            }
            Accessrights::create($data);
            return redirect()->route('vocab-record-level-access-rights.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Accessrights $accessRights)
    {
        return view('pages.vocab-record-level-access-rights.show', ['item' => $accessRights]);
    }

    public function edit(Accessrights $accessRights)
    {
        return view('pages.vocab-record-level-access-rights.edit', ['item' => $accessRights]);
    }

    public function update(Request $request, Accessrights $accessRights)
    {
        try {
            $data = $request->validate($this->rules($accessRights));
            $accessRights->update($data);
            return redirect()->route('vocab-record-level-access-rights.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Accessrights $accessRights)
    {
        try {
            $this->tx(fn () => $accessRights->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($accessRights = null): array
    {
        return [
            'accessrights_value' => [
                'required','string','max:200',
                Rule::unique('vocab_record_level_accessRights','accessrights_value')
                ->ignore($accessRights?->accessrights_id, 'accessrights_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
