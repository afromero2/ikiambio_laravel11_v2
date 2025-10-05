<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\License;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LicenseController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = License::orderByDesc('license_id')->paginate(15);
        return view('pages.vocab-record-level-license.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-license.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['license_id'] ?? null)) {
                $data['license_id'] = (string) Str::uuid();
            }
            License::create($data);
            return redirect()->route('vocab-record-level-license.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(License $license)
    {
        return view('pages.vocab-record-level-license.show', ['item' => $license]);
    }

    public function edit(License $license)
    {
        return view('pages.vocab-record-level-license.edit', ['item' => $license]);
    }

    public function update(Request $request, License $license)
    {
        try {
            $data = $request->validate($this->rules($license));
            $license->update($data);
            return redirect()->route('vocab-record-level-license.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(License $license)
    {
        try {
            $this->tx(fn () => $license->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($license = null): array
    {
        return [
            'license_value' => [
                'required','string','max:200',
                Rule::unique('vocab_record_level_license','license_value')
                ->ignore($license?->license_id, 'license_id')
            ],
            'description' => ['required','string'],
        ];

    }

}
