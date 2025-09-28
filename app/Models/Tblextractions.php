<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tblextractions extends Model
{
    protected $table = 'TblExtracciones';       // tal cual en PG
    protected $primaryKey = 'idExtracciones';   // <- NO es "id"
    public $incrementing = false;               // si usas UUID string
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idExtracciones','id_occ_bd','materialSampleType','idRegistros','fechaExtraccion',
        'purificationMethod','methodDeterminationConcentrationAndRatios','adn_enSTOCK',
        'volume','volumeUnit','concentration','concentrationUnit',
        'ratioOfAbsorbance260_280','ratioOfAbsorbance260_230',
        'preservationType','preservationTemperature','preservationDateBegin',
        'quality','qualityCheckDate','sieving',
        'codigoMuestraBiobanco','codigoADNBiobanco','codigoGermoplasmaBiobanco',
        'extractionStaff','qualityRemarks',
    ];

    protected static function booted()
    {
        static::creating(function ($m) {
            if (empty($m->idExtracciones)) {
                $m->idExtracciones = (string) Str::uuid();
            }
        });

        // Borra los hijos antes de borrar la extracción
        static::deleting(function (Tblextractions $ex) { 
            // Si NO usas SoftDeletes en el padre/hijo:
            // -> delete(): borrado normal
            // -> forceDelete(): borrado definitivo

            // Si el padre usa SoftDeletes y quieres respetarlo:
            if (method_exists($ex, 'isForceDeleting') && $ex->isForceDeleting()) {
                // Forzar borrado definitivo de los hijos (si los hijos también usan SoftDeletes, esto los elimina de verdad)
                $ex->regLaboratorio()->forceDelete();
            } else {
                // Borrado normal de los hijos
                $ex->regLaboratorio()->delete();
            }
        });

    }

    public function occurrence()
    {
        return $this->belongsTo(\App\Models\Occurrence::class, 'id_occ_bd', 'id_occ_bd');
    }

    // Para route model binding en recursos web/api:
    public function getRouteKeyName()
    {
        return $this->getKeyName(); // 'idExtracciones'
    }

    public function regLaboratorio()
    {
        // Una extracción tiene muchos registros de laboratorio
        return $this->hasMany(\App\Models\TblRegistrosLaboratorio::class, 'idExtracciones', 'idExtracciones');
    }

}
