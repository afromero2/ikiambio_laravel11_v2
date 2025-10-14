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
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

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
        ->paginate(4);    

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
        try {
            $data = $request->validate($this->rules());
            if (empty($data['locationID'] ?? null)) {
                $data['locationID'] = (string) Str::uuid();
            }
            Location::create($data);
            return redirect()->route('location.show', $data['locationID'])->with('ok', 'Location creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
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
        try {
            $data = $request->validate($this->rules($location));
            $location->update($data);

            $page = (int) $request->input('page', $request->query('page', 1));

            /* return redirect()->route('location.index', $location->locationID)->with('ok', 'Location actualizado'); */

            return redirect()->route('location.index', ['page' => max(1, $page)])->with('ok','Location actualizado');

        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Request $request, Location $location)
    {
        DB::transaction(function () use ($location) {
            $location->delete();
        });

        $page = (int) $request->input('page', $request->query('page', 1));

        /* return redirect()->route('location.index')->with('ok', 'Location eliminado'); */
        return redirect()->route('location.index', ['page' => max(1, $page)])->with('ok', 'Location eliminado');
    }

    protected function rules($location = null): array
    {
        return [
            'locationID'               => [$location ? 'sometimes' : 'nullable','string', Rule::unique('location','locationID')->ignore($location?->locationID,'locationID')],
            'id_INEC'                  => ['required','string'],
            'higherGeographyID'        => ['required','string'],
            'continent'                => ['required','integer','exists:vocab_location_continent,continent_id'],
            'waterBody'                => ['required','string'],
            'islandGroup'              => ['required','string'],
            'island'                   => ['required','string'],
            'country'                  => ['required','string'],
            'countryCode'              => ['required','string','size:2'],
            'stateProvince'            => ['required','string'],
            'county'                   => ['required','string'],
            'municipality'             => ['required','string'],
            'locality'                 => ['required','string'],
            'verbatimLocality'         => ['required','string'],
            'verbatimElevation'        => ['required','string'],
            'verbatimDepth'            => ['required','string'],
            'locationRemarks'          => ['required','string'],
            'decimalLatitude'          => ['required','numeric'],
            'decimalLongitude'         => ['required','numeric'],
            'geodeticDatum'            => ['required','string'],
            'verbatimLatitude'         => ['required','string'],
            'verbatimLongitude'        => ['required','string'],
            'verbatimCoordinateSystem' => ['required','string'],
            'verbatimSRS'              => ['required','integer','exists:vocab_location_verbatimSRS,verbatimSRS_id'],
            'georeferencedBy'          => ['required','string'],
            'georeferencedDate'        => ['required','date'],
            'georeferenceVerificationStatus' => ['required','integer','exists:vocab_location_georef_status,georef_status_id'],
            'georeferenceRemarks'      => ['required','string']
        ];
    }

}
