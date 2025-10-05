<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Type;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Type::orderByDesc('type_id')->paginate(15);
        return view('pages.vocab-record-level-type.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-type.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['type_id'] ?? null)) {
                $data['type_id'] = (string) Str::uuid();
            }
            Type::create($data);
            return redirect()->route('vocab-record-level-type.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Type $type)
    {
        return view('pages.vocab-record-level-type.show', ['item' => $type]);
    }

    public function edit(Type $type)
    {
        return view('pages.vocab-record-level-type.edit', ['item' => $type]);
    }

    public function update(Request $request, Type $type)
    {
        try {
            $data = $request->validate($this->rules($type));
            $type->update($data);
            return redirect()->route('vocab-record-level-type.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Type $type)
    {
        try {
            $this->tx(fn () => $type->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }

    protected function rules($type = null): array
    {
        return [
            'type_value' => [
                'required','string','max:20',
                Rule::unique('vocab_record_level_type','type_value')
                ->ignore($type?->type_id, 'type_id')
            ],
            'description' => ['required','string'],
        ];
    }

}
