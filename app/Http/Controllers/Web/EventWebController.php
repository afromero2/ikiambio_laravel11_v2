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
        $data = $request->all();

         $data = $request->validate([
            'parentEventID'                => ['required','string','max:255','unique:measurementorfacts,measurementID'],
            'eventDate'                    => ['required','date'], // ajusta si es int en tu esquema
            'eventTime'              => ['required','string','max:255'],
            'year'             => ['required','string','max:255'],
            'month'          => ['required','string','max:255'],
            'day'              => ['required','string','max:255'],
            'habitat'      => ['required','string','max:255'],
            'samplingProtocol'    => ['required','string'],
            'fieldNotes'            => ['required','string'],
            'locationID'           => ['required','string'],
            'eventRemarks'           => ['required','string'],
        ]);

        try {
            $item = DB::transaction(function () use ($data) {
                if (empty($data['eventID'])) {
                    $data['eventID'] = (string) Str::uuid();
                }
                return Event::create($data);
            });

            return redirect()
                ->route('location.index', $item->eventID)
                ->with('ok', 'Event creado');

        } catch (\Throwable $e) {
            Log::error('Measurementorfacts store error', ['msg'=>$e->getMessage()]);
            return back()->withErrors($e->getMessage())->withInput();
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
        $data = $request->all();
        try {
            $this->tx(fn () => $event->update($data));
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
}
