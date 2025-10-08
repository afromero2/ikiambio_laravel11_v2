<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class VocabTableSeeder extends Seeder
{
    /** tabla => [uniqueBy, rows] */
    protected function catalog(): array
    {
        return [
            // =========================
            // RECORD LEVEL
            // =========================
            'public.vocab_record_level_type' => [
                'uniqueBy' => ['type_value'],
                'rows' => [
                    ['type_value' => 'StillImage',     'description' => 'Imagen fija'],
                    ['type_value' => 'MovingImage',    'description' => 'Imagen en movimiento'],
                    ['type_value' => 'Sound',          'description' => 'Audio'],
                    ['type_value' => 'PhysicalObject', 'description' => 'Objeto físico'],
                    ['type_value' => 'Event',          'description' => 'Evento'],
                ],
            ],
            'public.vocab_record_level_license' => [
                'uniqueBy' => ['license_value'],
                'rows' => [
                    ['license_value' => 'https://creativecommons.org/licenses/by-nc/4.0/', 'description' => 'Licencia CC BY-NC 4.0'],
                ],
            ],
            'public."vocab_record_level_rightsHolder"' => [
                'uniqueBy' => ['rightsHolder_value'],
                'rows' => [
                    ['rightsHolder_value' => 'Laboratorio de Biología Integrativa', 'description' => 'Titular de derechos'],
                ],
            ],
            'public."vocab_record_level_accessRights"' => [
                'uniqueBy' => ['accessrights_value'],
                'rows' => [
                    ['accessrights_value' => 'https://creativecommons.org/licenses/by-nc/4.0/', 'description' => 'Acceso bajo CC BY-NC 4.0'],
                ],
            ],
            'public."vocab_record_level_institutionID"' => [
                'uniqueBy' => ['institutionID_value'],
                'rows' => [
                    ['institutionID_value' => '0c5cc67a-87d1-461a-beed-bc3bfb557287', 'description' => 'Identificador de institución (UUID)'],
                ],
            ],
            'public."vocab_record_level_collectionID"' => [
                'uniqueBy' => ['collection_value'],
                'rows' => [
                    ['collection_value' => 'Museo, Herbario o Fungario Amazónico Ikiam', 'description' => 'Colección institucional'],
                ],
            ],
            'public."vocab_record_level_institutionCode"' => [
                'uniqueBy' => ['institutionCode_value'],
                'rows' => [
                    ['institutionCode_value' => 'IKIAM', 'description' => 'Código de institución'],
                ],
            ],
            'public."vocab_record_level_collectionCode"' => [
                'uniqueBy' => ['collectionCode_value'],
                'rows' => [
                    ['collectionCode_value' => 'MA IKIAM', 'description' => 'Museo Amazónico Ikiam'],
                    ['collectionCode_value' => 'HA IKIAM', 'description' => 'Herbario Amazónico Ikiam'],
                    ['collectionCode_value' => 'FA IKIAM', 'description' => 'Fungario Amazónico Ikiam'],
                ],
            ],
            'public."vocab_record_level_ownerInstitutionCode"' => [
                'uniqueBy' => ['ownerinstitutioncode_value'],
                'rows' => [
                    ['ownerinstitutioncode_value' => 'Universidad Regional Amazónica Ikiam', 'description' => 'Institución propietaria'],
                ],
            ],
            'public."vocab_record_level_basisOfRecord"' => [
                'uniqueBy' => ['basisofrecord_value'],
                'rows' => [
                    ['basisofrecord_value' => 'PreservedSpecimen',   'description' => 'Ejemplar preservado'],
                    ['basisofrecord_value' => 'HumanObservation',    'description' => 'Observación humana'],
                    ['basisofrecord_value' => 'LivingSpecimen',      'description' => 'Ejemplar vivo'],
                    ['basisofrecord_value' => 'FossilSpecimen',      'description' => 'Fósil'],
                    ['basisofrecord_value' => 'MachineObservation',  'description' => 'Observación automática'],
                    ['basisofrecord_value' => 'MaterialSample',      'description' => 'Muestra de material'],
                    ['basisofrecord_value' => 'MaterialCitation',    'description' => 'Citación de material'],
                ],
            ],

            // =========================
            // OCCURRENCE
            // =========================
            'public."vocab_occurrence_organismQuantityType"' => [
                'uniqueBy' => ['oqtype_value'],
                'rows' => [
                    ['oqtype_value' => 'LOTE',        'description' => 'Lote de muestras'],
                    ['oqtype_value' => 'INDIVIDUOS',  'description' => 'Número de individuos'],
                ],
            ],
            'public.vocab_occurrence_sex' => [
                'uniqueBy' => ['sex_value'],
                'rows' => [
                    ['sex_value' => 'Hembra',         'description' => 'Sexo femenino'],
                    ['sex_value' => 'Hermafrodita',   'description' => 'Ambos sexos'],
                    ['sex_value' => 'Macho',          'description' => 'Sexo masculino'],
                    ['sex_value' => 'Desconocido',    'description' => 'Sin determinar'],
                    ['sex_value' => 'Indeterminado',  'description' => 'No aplicable o indeterminado'],
                    ['sex_value' => 'Ginandromorfo',  'description' => 'Presenta ambos fenotipos'],
                ],
            ],
            'public."vocab_occurrence_lifeStage"' => [
                'uniqueBy' => ['lifestage_value'],
                'rows' => [
                    ['lifestage_value' => 'Huevo',        'description' => 'Etapa huevo'],
                    ['lifestage_value' => 'Juvenil',      'description' => 'Etapa juvenil'],
                    ['lifestage_value' => 'Adulto',       'description' => 'Etapa adulta'],
                    ['lifestage_value' => 'Cigoto',       'description' => 'Etapa cigoto'],
                    ['lifestage_value' => 'Embrión',      'description' => 'Etapa embrión'],
                    ['lifestage_value' => 'Larva',        'description' => 'Etapa larval'],
                    ['lifestage_value' => 'Esporófito',   'description' => 'Plantas: esporófito'],
                    ['lifestage_value' => 'Espora',       'description' => 'Plantas: espora'],
                    ['lifestage_value' => 'Gametofito',   'description' => 'Plantas: gametófito'],
                    ['lifestage_value' => 'Gameto',       'description' => 'Célula germinal'],
                    ['lifestage_value' => 'Pupa',         'description' => 'Etapa pupa'],
                    ['lifestage_value' => 'Plántula',     'description' => 'Plantas: plántula'],
                    ['lifestage_value' => 'Floración',    'description' => 'Plantas: floración'],
                    ['lifestage_value' => 'Fructificación','description' => 'Plantas: fructificación'],
                ],
            ],
            'public."vocab_occurrence_reproductiveCondition"' => [
                'uniqueBy' => ['reprocond_value'],
                'rows' => [
                    ['reprocond_value' => 'Reproductiva',     'description' => 'En reproducción'],
                    ['reprocond_value' => 'No reproductiva',  'description' => 'Fuera de reproducción'],
                    ['reprocond_value' => 'En gestación',     'description' => 'Gestación'],
                    ['reprocond_value' => 'Floración',        'description' => 'Plantas: floración'],
                    ['reprocond_value' => 'Fructificación',   'description' => 'Plantas: fructificación'],
                ],
            ],
            'public."vocab_occurrence_establishmentMeans"' => [
                'uniqueBy' => ['estabmeans_value'],
                'rows' => [
                    ['estabmeans_value' => 'native',                          'description' => 'Nativa'],
                    ['estabmeans_value' => 'nativeReintroduced',              'description' => 'Nativa reintroducida'],
                    ['estabmeans_value' => 'introduced',                      'description' => 'Introducida'],
                    ['estabmeans_value' => 'introducedAssistedColonisation',  'description' => 'Introducida con colonización asistida'],
                    ['estabmeans_value' => 'vagrant',                         'description' => 'Errante'],
                    ['estabmeans_value' => 'uncertain',                       'description' => 'Incierta'],
                    ['estabmeans_value' => 'Endémica',                        'description' => 'Endémica'],
                ],
            ],
            'public.vocab_occurrence_disposition' => [
                'uniqueBy' => ['disposition_value'],
                'rows' => [
                    ['disposition_value' => 'preserved',   'description' => 'Preservado'],
                    ['disposition_value' => 'disposed',    'description' => 'Desechado'],
                    ['disposition_value' => 'in transit',  'description' => 'En tránsito'],
                    ['disposition_value' => 'loaned',      'description' => 'Prestado'],
                    ['disposition_value' => 'missing.',    'description' => 'Extraviado'],
                    ['disposition_value' => 'returned',    'description' => 'Devuelto'],
                    ['disposition_value' => 'unknown',     'description' => 'Desconocido'],
                ],
            ],

            // =========================
            // LOCATION
            // =========================
            'public.vocab_location_continent' => [
                'uniqueBy' => ['continent_value'],
                'rows' => [
                    ['continent_value' => 'América del Sur',  'description' => 'Continente'],
                    ['continent_value' => 'América del Norte','description' => 'Continente'],
                    ['continent_value' => 'Europa',           'description' => 'Continente'],
                    ['continent_value' => 'África',           'description' => 'Continente'],
                    ['continent_value' => 'Asia',             'description' => 'Continente'],
                    ['continent_value' => 'Oceanía',          'description' => 'Continente'],
                    ['continent_value' => 'Antártida',        'description' => 'Continente'],
                ],
            ],
            'public.vocab_location_georef_status' => [
                'uniqueBy' => ['georef_status_value'],
                'rows' => [
                    ['georef_status_value' => 'Inviable para georreferenciar',           'description' => 'No se puede georreferenciar'],
                    ['georef_status_value' => 'Requiere georreferenciación',            'description' => 'Debe asignarse coordenadas'],
                    ['georef_status_value' => 'Requiere verificación',                  'description' => 'Revisión pendiente'],
                    ['georef_status_value' => 'Verificado por el custodio de los datos','description' => 'Validado por custodio'],
                    ['georef_status_value' => 'Verificado por el proveedor de los datos','description' => 'Validado por proveedor'],
                ],
            ],

            // =========================
            // IDENTIFICATION
            // =========================
            'public."vocab_identification_typeStatus"' => [
                'uniqueBy' => ['typeStatus_value'],
                'rows' => [
                    ['typeStatus_value' => 'Holotipo',  'description' => 'Tipo primario'],
                    ['typeStatus_value' => 'Paratipo',  'description' => 'Tipo adicional'],
                    ['typeStatus_value' => 'Alotipo',   'description' => 'Tipo de sexo opuesto al holotipo'],
                    ['typeStatus_value' => 'Isotipo',   'description' => 'Duplicado del holotipo'],
                    ['typeStatus_value' => 'Neotipo',   'description' => 'Sustituye al tipo perdido'],
                    ['typeStatus_value' => 'Plastotipo','description' => 'Tipo plastificado (si aplica)'],
                    ['typeStatus_value' => 'Sintipo',   'description' => 'Varios ejemplares tipo'],
                    ['typeStatus_value' => 'Topotipo',  'description' => 'Del mismo sitio que el tipo'],
                ],
            ],
            'public."vocab_identification_verificationStatus"' => [
                'uniqueBy' => ['identificationVerificationStatus_value'],
                'rows' => [
                    ['identificationVerificationStatus_value' => 'Verificado por especialista', 'description' => 'Validado por experto'],
                ],
            ],

            // =========================
            // TAXON
            // =========================
            'public."vocab_taxon_taxonRank"' => [
                'uniqueBy' => ['taxonRank_value'],
                'rows' => [
                    ['taxonRank_value' => 'Reino',          'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subreino',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Filo',           'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'División',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subfilo',        'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subdivisión',    'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Clase',          'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subclase',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Orden',          'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Suborden',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Familia',        'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subfamilia',     'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Tribu',          'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subtribu',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Nothogénero',    'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Género',         'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subgénero',      'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Sección',        'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subsección',     'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Serie',          'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subserie',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Nothoespecie',   'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Especie',        'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Nothosubespecie','description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subespecie',     'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Variedad',       'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subvariedad',    'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Forma',          'description' => 'Rango taxonómico'],
                    ['taxonRank_value' => 'Subforma',       'description' => 'Rango taxonómico'],
                ],
            ],
            'public."vocab_taxon_taxonomicStatus"' => [
                'uniqueBy' => ['taxonomicStatus_value'],
                'rows' => [
                    ['taxonomicStatus_value' => 'Inválido',               'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Válido',                 'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Aceptado',               'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Sinónimo',               'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Sinónimo homotípico',    'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Sinónimo heterotípico',  'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Ambiguo',                'description' => 'Estatus taxonómico'],
                    ['taxonomicStatus_value' => 'Mal aplicado',           'description' => 'Estatus taxonómico'],
                ],
            ],
        ];
    }

    public function run(): void
    {
        $this->command?->info('VocabSeeder SIN upsert ('.__FILE__.')');

        DB::beginTransaction();
        try {
            foreach ($this->catalog() as $table => $cfg) {
                if (!$this->tableExists($table)) {
                    $this->command?->warn("VocabSeeder: tabla {$table} no existe. Saltando…");
                    continue;
                }

                $unique = $cfg['uniqueBy'] ?? [];
                $rows   = $cfg['rows'] ?? [];
                if (!$rows) continue;

                // 1) Autocompleta NOT NULL de texto (p.ej., description) si faltan
                $rows = array_map(function ($r) use ($table, $unique) {
                    return $this->autofillRequiredText($table, $r, $unique);
                }, $rows);

                // 2) Timestamps si existen
                $stamp = $this->timestampColumns($table);
                $rows = array_map(function ($r) use ($stamp) {
                    $now = Carbon::now();
                    if (in_array('created_at', $stamp) && !isset($r['created_at'])) $r['created_at'] = $now;
                    if (in_array('updated_at', $stamp) && !isset($r['updated_at'])) $r['updated_at'] = $now;
                    return $r;
                }, $rows);

                $updateCols = array_values(array_diff(array_keys(Arr::first($rows)), $unique));
                $this->portableMerge($table, $rows, $unique, $updateCols);

                $this->command?->info("OK: {$table} (".count($rows)." filas)");
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            $this->command?->error("VocabSeeder error: ".$e->getMessage());
            throw $e;
        }
    }

    /** UPDATE si coincide por uniqueBy; si no, INSERT. No requiere UNIQUE en BD. */
    protected function portableMerge(string $table, array $rows, array $unique, array $updateCols): void
    {
        foreach ($rows as $r) {
            $q = DB::table($this->tableStr($table));
            foreach ($unique as $u) {
                if (!array_key_exists($u, $r)) {
                    throw new \InvalidArgumentException("Falta clave '$u' en fila de {$table}");
                }
                $q->where($u, $r[$u]);
            }
            $exists = !empty($unique) ? $q->exists() : false;
            if ($exists && $updateCols) {
                $q->update(Arr::only($r, $updateCols));
            } elseif (!$exists) {
                DB::table($this->tableStr($table))->insert($r);
            }
        }
    }

    /** Rellena columnas de texto NOT NULL sin default (p.ej. description) si faltan. */
    protected function autofillRequiredText(string $qualified, array $row, array $unique): array
    {
        [$schema, $name] = $this->split($qualified);

        $required = DB::table('information_schema.columns')
            ->select('column_name')
            ->where('table_schema', $schema)
            ->where('table_name', $name)
            ->where('is_nullable', 'NO')
            ->whereNull('column_default')
            ->whereIn('data_type', ['character varying', 'text'])
            ->pluck('column_name')
            ->filter(fn ($c) => !in_array($c, ['id','created_at','updated_at']))
            ->values()
            ->all();

        $fallbackKey = $unique[0] ?? array_key_first($row);
        $fallbackVal = isset($row[$fallbackKey]) && is_scalar($row[$fallbackKey])
            ? (string)$row[$fallbackKey]
            : 'N/A';

        foreach ($required as $col) {
            if (!array_key_exists($col, $row) || $row[$col] === null || $row[$col] === '') {
                $row[$col] = $fallbackVal;
            }
        }
        return $row;
    }

    // ===== helpers de introspección / quoting =====
    protected function tableExists(string $qualified): bool
    {
        [$schema, $name] = $this->split($qualified);
        return DB::table('information_schema.tables')
            ->where('table_schema', $schema)
            ->where('table_name', $name)
            ->exists();
    }

    protected function timestampColumns(string $qualified): array
    {
        [$schema, $name] = $this->split($qualified);
        return DB::table('information_schema.columns')
            ->select('column_name')
            ->where('table_schema', $schema)
            ->where('table_name', $name)
            ->whereIn('column_name', ['created_at','updated_at'])
            ->pluck('column_name')
            ->all();
    }

 protected function tableStr(string $qualified): string
{
    // Devuelve schema.table SIN comillas; el Grammar de Postgres las pondrá bien.
    [$schema, $name] = $this->split($qualified);
    return $schema.'.'.$name;
}

    protected function split(string $qualified): array
    {
        $qualified = trim($qualified);
        if (!str_contains($qualified, '.')) return ['public', $this->unq($qualified)];
        [$s, $n] = explode('.', $qualified, 2);
        return [$this->unq($s), $this->unq($n)];
    }

    protected function unq(string $id): string
    {
        $id = trim($id);
        return (str_starts_with($id, '"') && str_ends_with($id, '"')) ? substr($id, 1, -1) : $id;
    }

    protected function q(string $id): string
    {
        return preg_match('/^[a-z0-9_]+$/', $id) ? $id : '"'.str_replace('"','""',$id).'"';
    }
}
