<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;

class TaxonAllInOneSeeder extends Seeder
{
    private string $csvRelPath = 'app/seed/taxon_MAATE_mapeado_v2.csv';

    public function run(): void
    {
        $csvPath = storage_path($this->csvRelPath);
        if (!file_exists($csvPath)) {
            $this->command->error("No se encontró el CSV: {$csvPath}");
            return;
        }

        /* ---------------- 1) VOCABS ---------------- */
        $rankValues   = ['Subforma','Forma','Subvariedad','Variedad','Subespecie','Nothosubespecie','Especie','Nothoespecie','Subserie','Serie','Subsección','Sección','Subgénero','Género','Nothogénero'];
        $statusValues = ['Inválido','Válido','Aceptado','Sinónimo','Sinónimo homotípico','Sinónimo heterotípico','Ambiguo','Mal aplicado'];

        $hasRankDesc   = Schema::hasColumn('vocab_taxon_taxonRank', 'description');
        $hasStatusDesc = Schema::hasColumn('vocab_taxon_taxonomicStatus', 'description');

        foreach ($rankValues as $v) {
            DB::table('vocab_taxon_taxonRank')->updateOrInsert(
                ['taxonRank_value' => $v],
                $hasRankDesc ? ['description' => 'Rango taxonómico'] : []
            );
        }
        foreach ($statusValues as $v) {
            DB::table('vocab_taxon_taxonomicStatus')->updateOrInsert(
                ['taxonomicStatus_value' => $v],
                $hasStatusDesc ? ['description' => 'Estatus taxonómico'] : []
            );
        }

        // Cache valor => id
        $rankCache = DB::table('vocab_taxon_taxonRank')->pluck('taxonRank_id','taxonRank_value')->all();
        $statusCache = DB::table('vocab_taxon_taxonomicStatus')->pluck('taxonomicStatus_id','taxonomicStatus_value')->all();

        /* -------- 2) Columnas existentes en taxon -------- */
        $cols = array_flip(Schema::getColumnListing('taxon'));
        $has  = fn(string $c) => array_key_exists($c, $cols);

        $rankFkCol     = $has('taxonRank_id') ? 'taxonRank_id' : ($has('taxonRank') ? 'taxonRank' : null);
        $statusFkCol   = $has('taxonomicStatus_id') ? 'taxonomicStatus_id' : ($has('taxonomicStatus') ? 'taxonomicStatus' : null);
        $rankTextCol   = $has('taxonRank_text') ? 'taxonRank_text' : null;
        $statusTextCol = $has('taxonomicStatus_text') ? 'taxonomicStatus_text' : null;

        // ¿FKs NOT NULL?
        $rankIsRequired   = $rankFkCol   ? self::isNotNullable('taxon', $rankFkCol)   : false;
        $statusIsRequired = $statusFkCol ? self::isNotNullable('taxon', $statusFkCol) : false;

        /* -------- 3) Siguiente taxonID numérico -------- */
        $sql = <<<'SQL'
SELECT COALESCE(
  MAX(CASE
        WHEN "taxonID" ~ '^[0-9]+$' THEN "taxonID"::bigint
        ELSE 0
      END),
  0
) AS maxid
FROM "taxon"
SQL;
        $maxRow = DB::selectOne($sql);
        $nextTaxonId = (int) $maxRow->maxid + 1;

        /* -------- 4) Leer CSV y procesar fila a fila -------- */
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        $inserted = 0; $updated = 0; $skipped = 0; $errored = 0;

        foreach ($csv->getRecords() as $row) {
            try {
                // --- limpiar valores ---
                $sciID   = self::cleanStr($row['scientificNameID'] ?? null);
                $sciName = self::cleanStr($row['scientificName'] ?? null);
                $auth    = self::cleanStr($row['scientificNameAuthorship'] ?? null);

                // si no tenemos ninguna forma de identificar, saltar
                if (!$sciID && !$sciName) { $skipped++; continue; }

                // Mapear vocabs a IDs
                $rankStr = self::mapRankStr(self::cleanStr($row['taxonRank'] ?? null));
                $statStr = self::mapStatusStr(self::cleanStr($row['taxonomicStatus'] ?? null));

                $rankId = $rankStr ? ($rankCache[$rankStr] ?? null) : null;
                if ($rankStr && !$rankId) {
                    $rankId = DB::table('vocab_taxon_taxonRank')->insertGetId(
                        ['taxonRank_value'=>$rankStr] + ($hasRankDesc?['description'=>'Rango taxonómico']:[]),
                        'taxonRank_id'
                    );
                    $rankCache[$rankStr] = $rankId;
                }

                $statusId = $statStr ? ($statusCache[$statStr] ?? null) : null;
                if ($statStr && !$statusId) {
                    $statusId = DB::table('vocab_taxon_taxonomicStatus')->insertGetId(
                        ['taxonomicStatus_value'=>$statStr] + ($hasStatusDesc?['description'=>'Estatus taxonómico']:[]),
                        'taxonomicStatus_id'
                    );
                    $statusCache[$statStr] = $statusId;
                }

                // Defaults si FKs son NOT NULL
                if ($statusIsRequired && !$statusId) {
                    $statStr = 'Aceptado';
                    $statusId = $statusCache[$statStr] ?? null;
                    if (!$statusId) {
                        $statusId = DB::table('vocab_taxon_taxonomicStatus')->insertGetId(
                            ['taxonomicStatus_value'=>$statStr] + ($hasStatusDesc?['description'=>'Estatus taxonómico']:[]),
                            'taxonomicStatus_id'
                        );
                        $statusCache[$statStr] = $statusId;
                    }
                }
                if ($rankIsRequired && !$rankId) {
                    $rankStr = 'Especie';
                    $rankId = $rankCache[$rankStr] ?? null;
                    if (!$rankId) {
                        $rankId = DB::table('vocab_taxon_taxonRank')->insertGetId(
                            ['taxonRank_value'=>$rankStr] + ($hasRankDesc?['description'=>'Rango taxonómico']:[]),
                            'taxonRank_id'
                        );
                        $rankCache[$rankStr] = $rankId;
                    }
                }

                // --- construir updateData SOLO con columnas que existan ---
                $updateData = [];
                $put = function(string $col, $val) use (&$updateData, $has) {
                    if ($val === null) return;
                    if ($has($col)) $updateData[$col] = $val;
                };

                $put('scientificNameID',         $sciID);
                $put('scientificName',           $sciName);
                $put('scientificNameAuthorship', $auth);
                $put('namePublishedInYear',      self::intOrNull($row['namePublishedInYear'] ?? null));
                $put('class',                    self::cleanStr($row['class'] ?? null));
                $put('order',                    self::cleanStr($row['order'] ?? null));
                $put('family',                   self::cleanStr($row['family'] ?? null));
                $put('genus',                    self::cleanStr($row['genus'] ?? null));
                $put('kingdom',                  self::cleanStr($row['kingdom'] ?? null));
                $put('phylum',                   self::cleanStr($row['phylum'] ?? null));
                $put('higherClassification',     self::cleanStr($row['higherClassification'] ?? null));
                $put('establishmentMeans',       self::cleanStr($row['establishmentMeans'] ?? null));
                $put('redListEcuador',           self::cleanStr($row['redListEcuador'] ?? null));
                $put('redListGlobal',            self::cleanStr($row['redListGlobal'] ?? null));

                if ($rankFkCol)     $updateData[$rankFkCol]     = $rankId;
                if ($statusFkCol)   $updateData[$statusFkCol]   = $statusId;
                if ($rankTextCol)   $updateData[$rankTextCol]   = $rankStr;
                if ($statusTextCol) $updateData[$statusTextCol] = $statStr;

                // --- localizar existente ---
                $existing = null;
                if ($sciID && $has('scientificNameID')) {
                    $existing = DB::table('taxon')->where('scientificNameID',$sciID)->first(['taxonID']);
                } else {
                    // clave compuesta si no hay scientificNameID (solo si las columnas existen)
                    $q = DB::table('taxon');
                    $conds = 0;
                    if ($sciName && $has('scientificName')) { $q->where('scientificName',$sciName); $conds++; }
                    if ($auth   && $has('scientificNameAuthorship')) { $q->where('scientificNameAuthorship',$auth); $conds++; }
                    if ($rankFkCol && $rankId) { $q->where($rankFkCol,$rankId); $conds++; }
                    $existing = $conds > 0 ? $q->first(['taxonID']) : null;
                }

                if ($existing) {
                    // UPDATE (NO tocamos taxonID)
                    DB::table('taxon')->where('taxonID',$existing->taxonID)->update($updateData);
                    $updated++;
                } else {
                    // INSERT nuevo → generar taxonID incremental numérico
                    $insertData = $updateData;
                    if ($has('taxonID')) $insertData['taxonID'] = (string)$nextTaxonId;
                    DB::table('taxon')->insert($insertData);
                    $nextTaxonId++;
                    $inserted++;
                }

            } catch (\Throwable $e) {
                $errored++;
                // Si quieres ver los primeros errores:
                // if ($errored < 5) $this->command->warn($e->getMessage());
                continue;
            }
        }

        $this->command->info("Taxon cargado. Insertados: {$inserted}, Actualizados: {$updated}, Omitidos: {$skipped}, Errores: {$errored}. Siguiente taxonID = {$nextTaxonId}");
    }

    /* ---------------- Helpers ---------------- */
    private static function cleanStr($v) {
        if ($v === null) return null;
        $s = trim((string)$v);
        if ($s === '' || $s === '?' || $s === '-' || strcasecmp($s,'N/A')===0 || strcasecmp($s,'NULL')===0) return null;
        return $s;
    }
    private static function intOrNull($v) {
        $s = self::cleanStr($v);
        return ($s !== null && is_numeric($s)) ? (int)$s : null;
    }
    private static function unaccentLower($s) {
        $s = mb_strtolower((string)$s,'UTF-8');
        return strtr($s, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ñ'=>'n']);
    }
    private static function mapRankStr($v) {
        if ($v === null) return null;
        $x = self::unaccentLower($v);
        $map = [
            'especie'=>'Especie','species'=>'Especie',
            'subespecie'=>'Subespecie','subspecies'=>'Subespecie',
            'variedad'=>'Variedad','variety'=>'Variedad',
            'subvariedad'=>'Subvariedad','subvariety'=>'Subvariedad',
            'forma'=>'Forma','form'=>'Forma','subforma'=>'Subforma','subform'=>'Subforma',
            'genero'=>'Género','género'=>'Género','genus'=>'Género',
            'subgenero'=>'Subgénero','subgénero'=>'Subgénero','subgenus'=>'Subgénero',
            'nothogenero'=>'Nothogénero','nothogénero'=>'Nothogénero',
            'seccion'=>'Sección','sección'=>'Sección','section'=>'Sección',
            'subseccion'=>'Subsección','subsección'=>'Subsección','subsection'=>'Subsección',
            'serie'=>'Serie','series'=>'Serie','subserie'=>'Subserie','subseries'=>'Subserie',
            'nothosubespecie'=>'Nothosubespecie','nothoespecie'=>'Nothoespecie',
        ];
        return $map[$x] ?? $v;
    }
    private static function mapStatusStr($v) {
        if ($v === null) return null;
        $x = self::unaccentLower($v);
        $map = [
            'aceptado'=>'Aceptado','accepted'=>'Aceptado',
            'valido'=>'Válido','válido'=>'Válido','valid'=>'Válido',
            'invalido'=>'Inválido','inválido'=>'Inválido','notaccepted'=>'Inválido',
            'sinonimo'=>'Sinónimo','sinónimo'=>'Sinónimo','synonym'=>'Sinónimo',
            'sinonimo homotipico'=>'Sinónimo homotípico','sinónimo homotípico'=>'Sinónimo homotípico','homotypicsynonym'=>'Sinónimo homotípico',
            'sinonimo heterotipico'=>'Sinónimo heterotípico','sinónimo heterotípico'=>'Sinónimo heterotípico','heterotypicsynonym'=>'Sinónimo heterotípico',
            'ambiguo'=>'Ambiguo','doubtful'=>'Ambiguo',
            'mal aplicado'=>'Mal aplicado','misapplied'=>'Mal aplicado',
        ];
        return $map[$x] ?? $v;
    }
    private static function isNotNullable(string $table, string $column): bool {
        $row = DB::selectOne(
            "select is_nullable from information_schema.columns where table_schema = current_schema() and table_name = ? and column_name = ?",
            [$table, $column]
        );
        return $row && strtolower($row->is_nullable ?? '') === 'no';
    }
}
