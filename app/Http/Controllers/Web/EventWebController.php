<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class EventWebController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Event::orderByDesc('eventID')->paginate(15);
        return view('pages.event.index', compact('items'));
    }

    public function create()
    {
        $locationId = request('location'); // viene del query string
        return view('pages.event.create', compact('locationId'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate($this->rules());
            if (empty($data['eventID'] ?? null)) {
                $data['eventID'] = (string) Str::uuid();
            }
            Event::create($data);

            $page = (int) $request->input('page', $request->query('page', 1)); 

            return redirect()->route('location.index',['page' => max(1, $page)])->with('ok','Creado:'.$page);
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function show(Event $event)
    {
        return view('pages.event.show', ['item' => $event]);
    }

    public function edit(Event $event)
    {
        return view('pages.event.edit', ['item' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        try {
            $data = $request->validate($this->rules($event));
            $event->update($data);
            return redirect()->route('location.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Event $event)
    {
        try {
            $this->tx(fn () => $event->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return $e;
            /* return back()->withErrors('No se pudo eliminar (posibles FKs).'); */
        }
    }

    protected function rules($event = null): array
    {
        return [
            'eventID'       => [
                $event ? 'sometimes' : 'nullable', 'string','max:100',
                Rule::unique('event','eventID')->ignore($event?->eventID, 'eventID')
            ],
            'parentEventID' => ['required','string','max:100'], // si apunta a event.eventID y quieres forzar FK: 'exists:event,eventID'
            'eventDate'     => ['required','date'],
            'eventTime'     => ['required','date_format:H:i:s'],
            'year'          => ['required','integer','between:1900,5000'],
            'month'         => ['required','integer','between:1,12'],
            'day'           => ['required','integer','between:1,31'],
            'habitat'       => ['required','string'],
            'samplingProtocol'=> ['required','string'],
            'fieldNotes'    => ['required','string'],
            'locationID'    => ['required','string','exists:location,locationID'],
            'eventRemarks'  => ['required','string']
        ];
    }

}
