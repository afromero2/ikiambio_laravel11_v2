<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class LocationSeeder extends Seeder
{
    protected string $csvPath = 'app/seed/location.csv';
    protected int $chunkSize = 1000;

    public function run(): void
    {
        $fullPath = storage_path($this->csvPath);
        if (!file_exists($fullPath)) {
            $this->command?->error("No se encontró el CSV: {$fullPath}");
            return;
        }

        $rows = $this->streamCsv($fullPath);

        $rows->chunk($this->chunkSize)->each(function ($chunk) {
            $payload = [];

            foreach ($chunk as $row) {
                // normaliza: '' → null
                $clean = [];
                foreach ($row as $k => $v) {
                    $key = trim((string)$k);
                    $val = is_null($v) ? null : trim((string)$v);
                    $clean[$key] = ($val === '') ? null : $val;
                }

                if (empty($clean['locationID'])) {
                    continue; // imprescindible
                }

                // Casters simples opcionales (si tus columnas NUMERIC/DATE lo requieren)
                foreach (['decimalLatitude','decimalLongitude'] as $num) {
                    if (isset($clean[$num]) && $clean[$num] !== null) {
                        $clean[$num] = is_numeric($clean[$num]) ? $clean[$num] : null;
                    }
                }
                if (!empty($clean['georeferencedDate'])) {
                    // Postgres aceptará 'YYYY-MM-DD' tal cual si viene en ese formato
                }

                $payload[] = $clean;
            }

            if ($payload) {
                $all = array_keys($payload[0]);
                $updateCols = array_values(array_diff($all, ['locationID'])); // no tocar PK

                DB::table('location')->upsert($payload, ['locationID'], $updateCols);
            }
        });

        $this->command?->info('Seeder Location completado.');
    }

    protected function streamCsv(string $path): LazyCollection
    {
        return LazyCollection::make(function () use ($path) {
            $h = fopen($path, 'r');
            if ($h === false) { return; }

            $header = null;
            try {
                while (($row = fgetcsv($h)) !== false) {
                    if ($header === null) {
                        $header = array_map('trim', $row);
                        continue;
                    }
                    $assoc = [];
                    foreach ($header as $i => $col) {
                        $assoc[$col] = $row[$i] ?? null;
                    }
                    yield $assoc;
                }
            } finally {
                fclose($h);
            }
        });
    }
}
