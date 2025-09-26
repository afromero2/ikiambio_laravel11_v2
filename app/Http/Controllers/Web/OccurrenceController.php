<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Occurrence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

// ===== Vocabs para OCCURRENCE =====
use App\Models\Vocab\Occurrence\Organismquantitytype;
use App\Models\Vocab\Occurrence\Sex;
use App\Models\Vocab\Occurrence\Lifestage;
use App\Models\Vocab\Occurrence\Reproductivecondition;
use App\Models\Vocab\Occurrence\Establishmentmeans;
use App\Models\Vocab\Occurrence\Disposition;

// ===== Vocabs para RECORD LEVEL =====
use App\Models\Vocab\RecordLevel\Type;
use App\Models\Vocab\RecordLevel\License;
use App\Models\Vocab\RecordLevel\Rightsholder;
use App\Models\Vocab\RecordLevel\Accessrights;
use App\Models\Vocab\RecordLevel\Institutionid;
use App\Models\Vocab\RecordLevel\Collectionid;
use App\Models\Vocab\RecordLevel\Institutioncode;
use App\Models\Vocab\RecordLevel\Collectioncode;
use App\Models\Vocab\RecordLevel\Ownerinstitutioncode;
use App\Models\Vocab\RecordLevel\Basisofrecord;

// ===== Vocabs para LOCATION =====
use App\Models\Vocab\Location\Continent;
use App\Models\Vocab\Location\Verbatimsrs;       // verifica: a veces la clase se llama VerbatimSrs
use App\Models\Vocab\Location\Georefstatus;

// ===== Vocabs para TAXON =====
use App\Models\Vocab\Taxon\TaxonRank;
use App\Models\Vocab\Taxon\TaxonomicStatus;

// ===== Vocabs para IDENTIFICATION =====
use App\Models\Vocab\Identification\TypeStatus;
use App\Models\Vocab\Identification\VerificationStatus;

use App\Models\Organism;
use App\Models\Location;
use App\Models\Taxon;
use App\Models\Identification;
use App\Models\RecordLevel;


class OccurrenceController extends Controller
{
    public function index()
    {
        $items = Occurrence::with([
            'recordLevelRef',
            'organismQuantityTypeRef','sexRef','lifeStageRef','reproductiveConditionRef',
            'establishmentMeansRef','dispositionRef',
            'organismRef',
            'measurements' => function ($q) {
                $q->select([
                    'measurementID',
                    'id_occ_bd',
                    'measurementType',   
                    'measurementValue'
                ])
                ->orderByDesc('measurementID');
            },
            'multimedia' => function ($q) {
                $q->select([
                    'idMultimedia',
                    'id_occ_bd',
                    'type',
                    'format',
                    'identifier',
                    'title'
                ])
                ->orderByDesc('idMultimedia');
            },
            'extractions' => function ($q) {
                $q->select([
                    'idExtracciones',
                    'id_occ_bd',
                    'volume', 
                    'volumeUnit',
                    'concentration',
                    'concentrationUnit'
                ])
                ->orderByDesc('idExtracciones');
            },
        ])
        ->withCount(['measurements','multimedia','extractions'])
        ->orderByDesc('id_occ_bd')
        ->paginate(15);

        return view('pages.occurrence.index', compact('items'));
    }

    public function create()
    {
        // lo que ya pasabas (recordLevels, oqtypes, sexes, etc.)
        $recordLevels   = RecordLevel::orderBy('record_level_id','desc')->get(['record_level_id','datasetName']);
        $oqtypes        = Organismquantitytype::orderBy('oqtype_value')->get(['oqtype_id','oqtype_value','description']);
        $sexes          = Sex::orderBy('sex_value')->get(['sex_id','sex_value']);
        $lifeStages     = LifeStage::orderBy('lifestage_value')->get(['lifestage_id','lifestage_value']);
        $reproConds     = ReproductiveCondition::orderBy('reprocond_value')->get(['reprocond_id','reprocond_value']);
        $estabMeans     = EstablishmentMeans::orderBy('estabmeans_value')->get(['estabmeans_id','estabmeans_value']);
        $dispositions   = Disposition::orderBy('disposition_value')->get(['disposition_id','disposition_value']);

        // NUEVO: selects de Location
        $continents     = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = VerbatimSrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses = GeorefStatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        return view('pages.occurrence.create', compact(
            'recordLevels','oqtypes','sexes','lifeStages','reproConds','estabMeans','dispositions',
            'continents','verbatimSrs','georefStatuses'
        ));
    }

    public function createWizard()
    {
        // Catálogos para la pestaña Occurrence
        $oqtypes      = Organismquantitytype::orderBy('oqtype_value')->get(['oqtype_id','oqtype_value','description']);
        $sexes        = Sex::orderBy('sex_value')->get(['sex_id','sex_value','description']);
        $lifeStages   = Lifestage::orderBy('lifestage_value')->get(['lifestage_id','lifestage_value','description']);
        $reproConds   = Reproductivecondition::orderBy('reprocond_value')->get(['reprocond_id','reprocond_value','description']);
        $estabMeans   = Establishmentmeans::orderBy('estabmeans_value')->get(['estabmeans_id','estabmeans_value','description']);
        $dispositions = Disposition::orderBy('disposition_value')->get(['disposition_id','disposition_value','description']);

        // Catálogos para la pestaña Record Level
        $types                = Type::orderBy('type_value')->get(['type_id','type_value','description']);
        $licenses             = License::orderBy('license_value')->get(['license_id','license_value','description']);
        $rightsHolders        = Rightsholder::orderBy('rightsHolder_value')->get(['rightsHolder_id','rightsHolder_value','description']);
        $accessRights         = Accessrights::orderBy('accessrights_value')->get(['accessrights_id','accessrights_value','description']);
        $institutionIds       = Institutionid::orderBy('institutionID_value')->get(['institution_id','institutionID_value','description']);
        $collectionIds        = Collectionid::orderBy('collection_value')->get(['collection_id','collection_value','description']);
        $institutionCodes     = Institutioncode::orderBy('institutionCode_value')->get(['institutionCode_id','institutionCode_value','description']);
        $collectionCodes      = Collectioncode::orderBy('collectionCode_value')->get(['collectionCode_id','collectionCode_value','description']);
        $ownerInstitutionCodes= Ownerinstitutioncode::orderBy('ownerinstitutioncode_value')->get(['ownerinstitutioncode_id','ownerinstitutioncode_value','description']);
        $basisOfRecords       = Basisofrecord::orderBy('basisofrecord_value')->get(['basisofrecord_id','basisofrecord_value','description']);

        // Catálogos para Location
        $continents      = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = Verbatimsrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses  = Georefstatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        // Catálogos para Taxon
        $taxonRanks         = TaxonRank::orderBy('taxonRank_value')->get(['taxonRank_id','taxonRank_value']);
        $taxonomicStatuses  = TaxonomicStatus::orderBy('taxonomicStatus_value')->get(['taxonomicStatus_id','taxonomicStatus_value']);

        // Catálogos para Identification
        $idTypeStatuses  = TypeStatus::orderBy('typeStatus_value')->get(['vocab_identification_typeStatus_id','typeStatus_value']);
        $idVerifStatuses = VerificationStatus::orderBy('identificationVerificationStatus_value')->get(['vocab_identification_verificationStatus_id','identificationVerificationStatus_value']);
        $typeStatuses = TypeStatus::orderBy('typeStatus_value')->get(['vocab_identification_typeStatus_id','typeStatus_value']);
        $verificationStatuses = VerificationStatus::orderBy('identificationVerificationStatus_value')->get(['vocab_identification_verificationStatus_id','identificationVerificationStatus_value']);


        $recordLevels = RecordLevel::orderByDesc('record_level_id')
            ->limit(50)
            ->get(['record_level_id','datasetName']);

         return view('pages.occurrence.create_wizard', compact(
            // Occurrence vocabs...
            'oqtypes','sexes','lifeStages','reproConds','estabMeans','dispositions',
            // Record level vocabs...
            'types','licenses','rightsHolders','accessRights','institutionIds','collectionIds','institutionCodes','collectionCodes','ownerInstitutionCodes','basisOfRecords',
            // Location vocabs...
            'continents','verbatimSrs','georefStatuses',
            // Taxon vocabs...
            'taxonRanks','taxonomicStatuses',
            // Identification vocabs...
            'idTypeStatuses','idVerifStatuses','typeStatuses','verificationStatuses',
            // >>> añade esto <<<
            'recordLevels'
        ));
    }

    public function store(Request $request)
    {
        // 1) VALIDACIÓN
        $data = $request->validate([
            // Uniques / IDs externos
            'occurrenceID'       => ['required','string','max:255','unique:occurrence,occurrenceID'],
            'catalogNumber'      => ['required','string','max:255','unique:occurrence,catalogNumber'],

            // FKs 1–1 y referencias externas (pueden ser null si en tu modelo lo permites)
            /* 'record_level_id'    => ['required','integer', Rule::exists('record_level','record_level_id')], */
            'record_level_id'    => ['required','integer', 'unique:occurrence,record_level_id',Rule::exists('record_level','record_level_id')],
            'identificationID'   => ['required','string','max:255','unique:occurrence,identificationID', Rule::exists('identification','identificationID')],

            'organismID'         => ['required','string','max:255', Rule::exists('organism','organismID')],
            'locationID'         => ['required','string','max:255', Rule::exists('location','locationID')],
            'taxonID'            => ['required','string','max:255', Rule::exists('taxon','taxonID')],
            
            // Requeridos de vocab
            'organismQuantityType' => ['required','integer', Rule::exists('vocab_occurrence_organismQuantityType','oqtype_id')],
            'sex'                   => ['required','integer', Rule::exists('vocab_occurrence_sex','sex_id')],
            'lifeStage'             => ['required','integer', Rule::exists('vocab_occurrence_lifeStage','lifestage_id')],
            'reproductiveCondition' => ['required','integer', Rule::exists('vocab_occurrence_reproductiveCondition','reprocond_id')],
            'establishmentMeans'    => ['required','integer', Rule::exists('vocab_occurrence_establishmentMeans','estabmeans_id')],
            'disposition'           => ['required','integer', Rule::exists('vocab_occurrence_disposition','disposition_id')],

            // Otros campos
            'recordNumber'        => ['required','string','max:255'],
            'recordedBy'          => ['required','string','max:255'],
            'individualCount'     => ['required','integer'],
            'organismQuantity'    => ['required','numeric'],
            'behavior'            => ['required','string'],
            'substrate'           => ['required','string'],
            'preparations'        => ['required','string'],
            'associatedMedia'     => ['required','string'],
            'associatedSequences' => ['required','string'],
            'associatedTaxa'      => ['required','string'],
            'otherCatalogNumbers' => ['required','string'],
            'occurrenceRemarks'   => ['required','string'],
        ], [
            // Mensajes personalizados (ejemplos)
            'organismQuantityType.required' => 'El tipo de cantidad del organismo es obligatorio.',
            'sex.required'                  => 'El campo Sex es obligatorio.',
            'lifeStage.required'            => 'El campo Life stage es obligatorio.',
            // ...
        ]);

        try {
            DB::transaction(function () use ($data) {
                \App\Models\Occurrence::create($data);
            });

            return redirect()->route('occurrence.index')->with('ok','Occurrence creado correctamente');
        } catch (QueryException $e) {
            Log::error('Error al guardar Occurrence', ['error' => $e->getMessage()]);
            return back()->withErrors('No se pudo guardar la Occurrence. Revise los datos o contacte al admin.')
                        ->withInput();
        }
    }

    public function show(Occurrence $occurrence)
    {
        $occurrence->load([
            'recordLevelRef',
            'organismQuantityTypeRef','sexRef','lifeStageRef','reproductiveConditionRef',
            'establishmentMeansRef','dispositionRef',
            'organismRef',
        ]);

        return view('pages.occurrence.show', ['item' => $occurrence]);
    }

    public function edit(\App\Models\Occurrence $occurrence)
    {
        // ===== Catálogos para la pestaña Occurrence =====
        $oqtypes      = \App\Models\Vocab\Occurrence\Organismquantitytype::orderBy('oqtype_value')->get(['oqtype_id','oqtype_value','description']);
        $sexes        = \App\Models\Vocab\Occurrence\Sex::orderBy('sex_value')->get(['sex_id','sex_value','description']);
        $lifeStages   = \App\Models\Vocab\Occurrence\Lifestage::orderBy('lifestage_value')->get(['lifestage_id','lifestage_value','description']);
        $reproConds   = \App\Models\Vocab\Occurrence\Reproductivecondition::orderBy('reprocond_value')->get(['reprocond_id','reprocond_value','description']);
        $estabMeans   = \App\Models\Vocab\Occurrence\Establishmentmeans::orderBy('estabmeans_value')->get(['estabmeans_id','estabmeans_value','description']);
        $dispositions = \App\Models\Vocab\Occurrence\Disposition::orderBy('disposition_value')->get(['disposition_id','disposition_value','description']);

        // ===== Catálogos para Record Level =====
        $types                 = \App\Models\Vocab\RecordLevel\Type::orderBy('type_value')->get(['type_id','type_value','description']);
        $licenses              = \App\Models\Vocab\RecordLevel\License::orderBy('license_value')->get(['license_id','license_value','description']);
        $rightsHolders         = \App\Models\Vocab\RecordLevel\Rightsholder::orderBy('rightsHolder_value')->get(['rightsHolder_id','rightsHolder_value','description']);
        $accessRights          = \App\Models\Vocab\RecordLevel\Accessrights::orderBy('accessrights_value')->get(['accessrights_id','accessrights_value','description']);
        $institutionIds        = \App\Models\Vocab\RecordLevel\Institutionid::orderBy('institutionID_value')->get(['institution_id','institutionID_value','description']);
        $collectionIds         = \App\Models\Vocab\RecordLevel\Collectionid::orderBy('collection_value')->get(['collection_id','collection_value','description']);
        $institutionCodes      = \App\Models\Vocab\RecordLevel\Institutioncode::orderBy('institutionCode_value')->get(['institutionCode_id','institutionCode_value','description']);
        $collectionCodes       = \App\Models\Vocab\RecordLevel\Collectioncode::orderBy('collectionCode_value')->get(['collectionCode_id','collectionCode_value','description']);
        $ownerInstitutionCodes = \App\Models\Vocab\RecordLevel\Ownerinstitutioncode::orderBy('ownerinstitutioncode_value')->get(['ownerinstitutioncode_id','ownerinstitutioncode_value','description']);
        $basisOfRecords        = \App\Models\Vocab\RecordLevel\Basisofrecord::orderBy('basisofrecord_value')->get(['basisofrecord_id','basisofrecord_value','description']);

        // ===== Catálogos para Location =====
        $continents     = \App\Models\Vocab\Location\Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = \App\Models\Vocab\Location\Verbatimsrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses = \App\Models\Vocab\Location\Georefstatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        // ===== Catálogos para Taxon =====
        $taxonRanks        = \App\Models\Vocab\Taxon\TaxonRank::orderBy('taxonRank_value')->get(['taxonRank_id','taxonRank_value']);
        $taxonomicStatuses = \App\Models\Vocab\Taxon\TaxonomicStatus::orderBy('taxonomicStatus_value')->get(['taxonomicStatus_id','taxonomicStatus_value']);

        // ===== Catálogos para Identification =====
        $idTypeStatuses        = \App\Models\Vocab\Identification\TypeStatus::orderBy('typeStatus_value')->get(['vocab_identification_typeStatus_id','typeStatus_value']);
        $idVerifStatuses       = \App\Models\Vocab\Identification\VerificationStatus::orderBy('identificationVerificationStatus_value')->get(['vocab_identification_verificationStatus_id','identificationVerificationStatus_value']);
        $typeStatuses          = $idTypeStatuses;       // mismos datos
        $verificationStatuses  = $idVerifStatuses;      // mismos datos

        // Opcional: últimos RL para sugerencias/buscador
        $recordLevels = \App\Models\RecordLevel::orderByDesc('record_level_id')
            ->limit(50)->get(['record_level_id','datasetName']);

        // === << clave: pasar $item >> ===
        $item = $occurrence;

        return view('pages.occurrence.create_wizard', compact(
            // Occurrence vocabs
            'oqtypes','sexes','lifeStages','reproConds','estabMeans','dispositions',
            // Record level vocabs
            'types','licenses','rightsHolders','accessRights','institutionIds','collectionIds','institutionCodes','collectionCodes','ownerInstitutionCodes','basisOfRecords',
            // Location vocabs
            'continents','verbatimSrs','georefStatuses',
            // Taxon vocabs
            'taxonRanks','taxonomicStatuses',
            // Identification vocabs
            'idTypeStatuses','idVerifStatuses','typeStatuses','verificationStatuses',
            // comunes
            'recordLevels','item'
        ));
    }

    public function update(Request $request, \App\Models\Occurrence $occurrence)
    {
        $data = $request->validate([
            'occurrenceID'       => ['required','string','max:255', Rule::unique('occurrence','occurrenceID')->ignore($occurrence->id_occ_bd, 'id_occ_bd')],
            'catalogNumber'      => ['required','string','max:255', Rule::unique('occurrence','catalogNumber')->ignore($occurrence->id_occ_bd, 'id_occ_bd')],
            'record_level_id'    => ['required','integer', 
                Rule::exists('record_level','record_level_id'),
                Rule::unique('occurrence','record_level_id')->ignore($occurrence->id_occ_bd, 'id_occ_bd')
            ],
            
            'organismID'         => ['required','string','max:255', Rule::exists('organism','organismID')],
            'locationID'         => ['required','string','max:255', Rule::exists('location','locationID')],
            'taxonID'            => ['required','string','max:255', Rule::exists('taxon','taxonID')],
            'identificationID'   => ['required','string','max:255', 
                Rule::exists('identification','identificationID'),
                Rule::unique('occurrence','identificationID')->ignore($occurrence->id_occ_bd, 'id_occ_bd')
            ], 
            
            'organismQuantityType' => ['required','integer', Rule::exists('vocab_occurrence_organismQuantityType','oqtype_id')],
            'sex'                   => ['required','integer', Rule::exists('vocab_occurrence_sex','sex_id')],
            'lifeStage'             => ['required','integer', Rule::exists('vocab_occurrence_lifeStage','lifestage_id')],
            'reproductiveCondition' => ['required','integer', Rule::exists('vocab_occurrence_reproductiveCondition','reprocond_id')],
            'establishmentMeans'    => ['required','integer', Rule::exists('vocab_occurrence_establishmentMeans','estabmeans_id')],
            'disposition'           => ['required','integer', Rule::exists('vocab_occurrence_disposition','disposition_id')],

            'recordNumber'        => ['required','string','max:255'],
            'recordedBy'          => ['required','string','max:255'],
            'individualCount'     => ['required','integer'],
            'organismQuantity'    => ['required','numeric'],
            'behavior'            => ['required','string'],
            'substrate'           => ['required','string'],
            'preparations'        => ['required','string'],
            'associatedMedia'     => ['required','string'],
            'associatedSequences' => ['required','string'],
            'associatedTaxa'      => ['required','string'],
            'otherCatalogNumbers' => ['required','string'],
            'occurrenceRemarks'   => ['required','string'],
        ]);

        try {
            DB::transaction(function () use ($occurrence, $data) {
                $occurrence->update($data);
            });

            return redirect()->route('occurrence.show', $occurrence)->with('ok','Occurrence actualizada');
        } catch (QueryException $e) {
            Log::error('Error al actualizar Occurrence', ['error' => $e->getMessage()]);
            return back()->withErrors('No se pudo actualizar. Revise los datos.')->withInput();
        }
    }

    /* public function destroy(Occurrence $occurrence)
    {
        DB::transaction(function () use ($occurrence) {
            // Guarda llaves antes del delete de occurrence
            $rid    = $occurrence->record_level_id;         // int
            $ident  = $occurrence->identificationID;        // varchar
            $idOcc  = (string) $occurrence->id_occ_bd;      // PK (int) -> para tablas con varchar

            // === A) Dependientes por idExtracciones -> TblRegistrosLaboratorio ===
            // 1. Obtén los idExtracciones vinculados a esta occurrence
            $extrIds = DB::table('TblExtracciones')
                ->where('id_occ_bd', $idOcc)
                ->pluck('idExtracciones')
                ->filter()
                ->values()
                ->all();

            // 2. Borra primero registros de laboratorio que dependan de esas extracciones
            if (!empty($extrIds)) {
                DB::table('TblRegistrosLaboratorio')
                ->whereIn('idExtracciones', $extrIds)
                ->delete();
            }

            // 1) Borra la occurrence primero (evita FKs hacia record_level)
            $occurrence->delete();

            if ($rid) {
                DB::table('record_level')->where('record_level_id', $rid)->delete();
            }

            if ($ident) {
                DB::table('identification')->where('identificationID', $ident)->delete();
            }

            // 4) Borra dependientes por id_occ_bd
            DB::table('TblExtracciones')->where('id_occ_bd', $idOcc)->delete();
            DB::table('measurementorfacts')->where('id_occ_bd', $idOcc)->delete();
            DB::table('TblMultimedia')->where('id_occ_bd', $idOcc)->delete();

        });

        return back()->with('ok', 'Occurrence y sus dependencias fueron eliminadas.');
    }  */ 
        
    public function destroy(\App\Models\Occurrence $occurrence)
    {
        // El evento deleting() del modelo hará el barrido en cadena.
        $occurrence->delete();

        return redirect()
            ->route('occurrence.index')
            ->with('ok','Occurrence y sus datos relacionados fueron eliminados.');
    }    

    // ================= Helpers =================

    private function options(): array
    {
        return [
            'recordLevels' => RecordLevel::orderByDesc('record_level_id')
                ->get(['record_level_id','datasetName']),

            'oqtypes' => Organismquantitytype::orderBy('oqtype_value')
                ->get(['oqtype_id','oqtype_value','description']),

            'sexes' => Sex::orderBy('sex_value')
                ->get(['sex_id','sex_value','description']),

            'lifeStages' => Lifestage::orderBy('lifestage_value')
                ->get(['lifestage_id','lifestage_value','description']),

            'reproConds' => Reproductivecondition::orderBy('reprocond_value')
                ->get(['reprocond_id','reprocond_value','description']),

            'estabMeans' => Establishmentmeans::orderBy('estabmeans_value')
                ->get(['estabmeans_id','estabmeans_value','description']),

            'dispositions' => Disposition::orderBy('disposition_value')
                ->get(['disposition_id','disposition_value','description']),

            // Si quieres sugerir organisms existentes:
            // 'organisms' => Organism::orderBy('organismID')->get(['organismID']),
        ];
    }

    private function validated(Request $request, ?Occurrence $occurrence = null): array
    {
        $id = $occurrence?->getKey();

        return $request->validate([
            'occurrenceID' => [
                'nullable','string',
                Rule::unique((new Occurrence)->getTable(), 'occurrenceID')->ignore($id, 'id_occ_bd'),
            ],
            /* 'record_level_id' => ['nullable','integer', Rule::exists((new RecordLevel)->getTable(),'record_level_id')], */
            'record_level_id' => ['nullable','integer', Rule::unique((new RecordLevel)->getTable(),'record_level_id')],

            'catalogNumber' => [
                'nullable','string',
                Rule::unique((new Occurrence)->getTable(), 'catalogNumber')->ignore($id, 'id_occ_bd'),
            ],

            'recordNumber' => ['nullable','string'],
            'recordedBy'   => ['nullable','string'],

            'individualCount' => ['nullable','integer'],
            'organismQuantity'=> ['nullable','numeric'],

            'organismQuantityType' => ['required','integer', Rule::exists((new Organismquantitytype)->getTable(),'oqtype_id')],
            'sex'                 => ['required','integer', Rule::exists((new Sex)->getTable(),'sex_id')],
            'lifeStage'           => ['required','integer', Rule::exists((new Lifestage)->getTable(),'lifestage_id')],
            'reproductiveCondition'=> ['required','integer', Rule::exists((new Reproductivecondition)->getTable(),'reprocond_id')],
            'establishmentMeans'  => ['required','integer', Rule::exists((new Establishmentmeans)->getTable(),'estabmeans_id')],
            'disposition'         => ['required','integer', Rule::exists((new Disposition)->getTable(),'disposition_id')],

            'behavior'            => ['nullable','string'],
            'substrate'           => ['nullable','string'],
            'preparations'        => ['nullable','string'],
            'associatedMedia'     => ['nullable','string'],
            'associatedSequences' => ['nullable','string'],
            'associatedTaxa'      => ['nullable','string'],
            'otherCatalogNumbers' => ['nullable','string'],
            'occurrenceRemarks'   => ['nullable','string'],

            'organismID'          => [
                'nullable','string',
                Rule::unique((new Organism)->getTable(), 'organismID'),
            ], // si quieres validar que exista: Rule::exists((new Organism)->getTable(),'organismID')
            'locationID'          => [
                'nullable','string',
                Rule::unique((new Location)->getTable(), 'locationID')
            ],
            'taxonID'             => [
                'nullable','string',
                Rule::unique((new Taxon)->getTable(), 'taxonID')
            ],
            'identificationID' => [
                'nullable','string',
                Rule::unique((new Occurrence)->getTable(), 'identificationID')->ignore($id, 'id_occ_bd'),
            ],
        ]);
    }

    private function ensureStringPk(?string $id): string
    {
        // Si el usuario no envía un ID, generamos uno
        return $id && trim($id) !== '' ? trim($id) : (string) Str::uuid();
    }

    private function upsertOrganism(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        // Puedes pasar más campos si los tienes en el form
        Organism::firstOrCreate(['organismID' => $id], [
            'associatedOccurrences' => null,
            'associatedOrganisms'   => null,
            'previousIdentifications'=> null,
        ]);
        return $id;
    }

    private function upsertLocation(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        Location::firstOrCreate(['locationID' => $id], []);
        return $id;
    }

    private function upsertTaxon(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        Taxon::firstOrCreate(['taxonID' => $id], []);
        return $id;
    }

    private function upsertIdentification(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        Identification::firstOrCreate(['identificationID' => $id], []);
        return $id;
    }


}
