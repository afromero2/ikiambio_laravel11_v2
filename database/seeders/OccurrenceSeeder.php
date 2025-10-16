<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OccurrenceSeeder extends Seeder
{
    public function run(): void
    {
        // FK mínimas (ajusta si tus tablas/columnas difieren)
        $recordLevels     = DB::table('record_level')->pluck('record_level_id')->toArray();
        $locations        = DB::table('location')->pluck('locationID')->toArray();
        $taxa             = DB::table('taxon')->pluck('taxonID')->toArray();
        $organisms        = DB::table('organism')->pluck('organismID')->toArray();
        $identifications  = DB::table('identification')->pluck('identificationID')->toArray();

        // Vocabularios
        $oqTypes       = DB::table('vocab_occurrence_organismQuantityType')->pluck('oqtype_id')->toArray();
        $sexes         = DB::table('vocab_occurrence_sex')->pluck('sex_id')->toArray();
        $lifeStages    = DB::table('vocab_occurrence_lifeStage')->pluck('lifestage_id')->toArray();
        $reproConds    = DB::table('vocab_occurrence_reproductiveCondition')->pluck('reprocond_id')->toArray();
        $estabMeans    = DB::table('vocab_occurrence_establishmentMeans')->pluck('estabmeans_id')->toArray();
        $dispositions  = DB::table('vocab_occurrence_disposition')->pluck('disposition_id')->toArray();

        // Validación mínima para no romper
        foreach ([
            'record_level' => $recordLevels,
            'location'     => $locations,
            'taxon'        => $taxa,
            'organism'     => $organisms,
            'identification'=> $identifications,
            'oqtype'       => $oqTypes,
            'sex'          => $sexes,
            'lifestage'    => $lifeStages,
            'reprocond'    => $reproConds,
            'estabmeans'   => $estabMeans,
            'disposition'  => $dispositions,
        ] as $name => $arr) {
            if (empty($arr)) {
                $this->command?->warn("Faltan datos en: {$name}. Aborto del seeder de occurrence.");
                return;
            }
        }

        $faker = \Faker\Factory::create('es_EC');
        $data  = [];

        for ($i = 1; $i <= 1; $i++) {
            $data[] = [
                // Uniques
                'occurrenceID'       => 'UOCC-'.str_pad((string)$i, 4, '0', STR_PAD_LEFT),
                'catalogNumber'      => 'UCAT-'.str_pad((string)$i, 4, '0', STR_PAD_LEFT),

                // FKs 1–1 / externas
                'record_level_id'    => $faker->randomElement($recordLevels),
                'identificationID'   => $faker->randomElement($identifications),
                'organismID'         => $faker->randomElement($organisms),
                'locationID'         => $faker->randomElement($locations),
                'taxonID'            => $faker->randomElement($taxa),

                // Vocab requeridos
                'organismQuantityType' => $faker->randomElement($oqTypes),
                'sex'                   => $faker->randomElement($sexes),
                'lifeStage'             => $faker->randomElement($lifeStages),
                'reproductiveCondition' => $faker->randomElement($reproConds),
                'establishmentMeans'    => $faker->randomElement($estabMeans),
                'disposition'           => $faker->randomElement($dispositions),

                // Otros campos
                'recordNumber'        => $faker->numerify('REC-####'),
                'recordedBy'          => $faker->name(),
                'individualCount'     => $faker->numberBetween(1, 10),
                'organismQuantity'    => $faker->randomFloat(2, 0.1, 5.0),
                'behavior'            => $faker->randomElement(['reposando','en movimiento','alimentándose','cantando']),
                'substrate'           => $faker->randomElement(['roca','hojarasca','tronco','vegetación','agua superficial']),
                'preparations'        => $faker->randomElement(['tejido preservado','fotografía','audio']),
                'associatedMedia'     => $faker->imageUrl(800, 600, 'nature', true),
                'associatedSequences' => $faker->randomElement(['SEQ-A1','SEQ-B2','SEQ-C3']),
                'associatedTaxa'      => $faker->randomElement(['Rana sp.','Hyloxalus sp.','Pristimantis sp.']),
                'otherCatalogNumbers' => $faker->numerify('OTH-###'),
                'occurrenceRemarks'   => $faker->sentence(8),
            ];
        }

        // UPSERT por occurrenceID para que no falle si lo corres dos veces
        DB::table('occurrence')->upsert($data, ['occurrenceID'], array_keys($data[0]));

        $this->command?->info('✅ Se poblaron 100 occurrences (upsert por occurrenceID, sin timestamps).');
    }
}
