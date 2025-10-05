<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Location;
// Vocabs (para selects en create/edit)
use App\Models\Vocab\Location\Continent;
use App\Models\Vocab\Location\VerbatimSrs;
use App\Models\Vocab\Location\GeorefStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationWebController extends Controller
{
    public function index()
    {   
        $items = Location::with([
            'continentRef',
            'verbatimSrsRef',
            'georefStatusRef',
            'events' => function ($q) {
                $q->select([
                    'eventID',
                    'locationID',   // ¡IMPORTANTE! incluir FK para que Eloquent relacione
                    'samplingProtocol',
                    'eventDate',
                    'eventTime',
                    'fieldNotes'
                ])
                ->orderByDesc('eventDate')
                ->orderBy('eventTime');
            },
        ])
        ->withCount('events')        // $location->events_count disponible en la vista
        ->orderBy('locationID')
        ->paginate(15);    

        return view('pages.location.index', compact('items'));
    }

    public function create()
    {
        $continents     = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = VerbatimSrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses = GeorefStatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        return view('pages.location.create', compact('continents','verbatimSrs','georefStatuses'));
    }

    public function store(Request $request)
    {
        $data = $this->rules($request);

        // Si no envían locationID, generamos uno (UUID)
        $id = $data['locationID'] ?: Str::uuid()->toString();

        DB::transaction(function () use (&$id, $data) {
            Location::updateOrCreate(
                ['locationID' => $id],
                collect($data)->except('locationID')->toArray()
            );
        });

        return redirect()->route('location.show', $id)->with('ok', 'Location creado');
    }

    public function show(Location $location)
    {
        $item = $location->load(['continentRef','verbatimSrsRef','georefStatusRef']);
        return view('pages.location.show', compact('item'));
    }

    public function edit(Location $location)
    {
        $continents     = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = VerbatimSrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses = GeorefStatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        $item = $location;

        return view('pages.location.edit', compact('item','continents','verbatimSrs','georefStatuses'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $this->rules($request, updating: true);

        DB::transaction(function () use ($location, $data) {
            // No permitimos cambiar la PK aquí; si quisieras, maneja $data['locationID']
            $location->update(collect($data)->except('locationID')->toArray());
        });

        return redirect()->route('location.index', $location->locationID)->with('ok', 'Location actualizado');
    }

    public function destroy(Location $location)
    {
        DB::transaction(function () use ($location) {
            $location->delete();
        });

        return redirect()->route('location.index')->with('ok', 'Location eliminado');
    }

    /** Validación compartida */
    private function rules(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'locationID' => ['nullable','string','max:255'], // PK string
            'id_INEC' => ['nullable','string','max:255'],
            'higherGeographyID' => ['nullable','string','max:255'],
            'continent' => ['required','integer'],
            'waterBody' => ['nullable','string'],
            'islandGroup' => ['nullable','string'],
            'island' => ['nullable','string'],
            'country' => ['nullable','string'],
            'countryCode' => ['nullable','string','max:2'],
            'stateProvince' => ['nullable','string'],
            'county' => ['nullable','string'],
            'municipality' => ['nullable','string'],
            'locality' => ['nullable','string'],
            'verbatimLocality' => ['nullable','string'],
            'verbatimElevation' => ['nullable','string'],
            'verbatimDepth' => ['nullable','string'],
            'locationRemarks' => ['nullable','string'],
            'decimalLatitude' => ['nullable','numeric'],
            'decimalLongitude' => ['nullable','numeric'],
            'geodeticDatum' => ['nullable','string'],
            'verbatimLatitude' => ['nullable','string'],
            'verbatimLongitude' => ['nullable','string'],
            'verbatimCoordinateSystem' => ['nullable','string'],
            'verbatimSRS' => ['required','integer'],
            'georeferencedBy' => ['nullable','string'],
            'georeferencedDate' => ['nullable','date'], // Y-m-d
            'georeferenceVerificationStatus' => ['required','integer'],
            'georeferenceRemarks' => ['nullable','string'],
        ]);
    }
}
