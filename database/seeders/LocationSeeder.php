<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Ruta del CSV (ajústala si deseas).
     */
    protected string $csvPath = 'app/seed/locations.csv';

    /**
     * Tamaño de lote para upsert.
     */
    protected int $chunkSize = 1000;

    public function run(): void
    {
        $fullPath = storage_path($this->csvPath);
        if (!file_exists($fullPath)) {
            $this->command?->error("No se encontró el CSV: {$fullPath}");
            return;
        }

        $rows = $this->streamCsv($fullPath);

        $now = now();

        $rows->chunk($this->chunkSize)->each(function ($chunk) use ($now) {
            $payload = [];

            foreach ($chunk as $row) {
                // Normaliza: '' -> null y trimea
                $clean = [];
                foreach ($row as $k => $v) {
                    $key = trim((string) $k);
                    $val = is_null($v) ? null : trim((string) $v);
                    $clean[$key] = ($val === '') ? null : $val;
                }

                // Campos de auditoría (si los tienes)
                $clean['created_at'] = $now;
                $clean['updated_at'] = $now;

                // Seguridad: exige locationID
                if (empty($clean['locationID'])) {
                    // Saltar fila sin locationID
                    continue;
                }

                $payload[] = $clean;
            }

            if (empty($payload)) {
                return;
            }

            // Columnas a actualizar = todas menos la clave
            $allColumns = array_keys($payload[0]);
            $updateCols = array_values(array_diff($allColumns, ['locationID']));

            // UPSERT por locationID (requiere PK/UNIQUE en locationID)
            DB::table('location')->upsert($payload, ['locationID'], $updateCols);
        });

        $this->command?->info('Seeder Location: completado.');
    }

    /**
     * Lee el CSV como LazyCollection (streaming).
     */
    protected function streamCsv(string $path): LazyCollection
    {
        return LazyCollection::make(function () use ($path) {
            $handle = fopen($path, 'r');
            if ($handle === false) {
                yield from [];
                return;
            }

            $header = null;
            try {
                while (($row = fgetcsv($handle)) !== false) {
                    // Detecta separador si fuera necesario (aquí suponemos coma)
                    if ($header === null) {
                        $header = array_map(fn($h) => trim((string)$h), $row);
                        continue;
                    }
                    // Combina encabezados con fila
                    $assoc = [];
                    foreach ($header as $i => $col) {
                        $assoc[$col] = $row[$i] ?? null;
                    }
                    yield $assoc;
                }
            } finally {
                fclose($handle);
            }
        });
    }
}
