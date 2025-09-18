<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Occurrence extends Model
{
    protected $table = 'occurrence';
    protected $primaryKey = 'id_occ_bd';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'occurrenceID',
        'record_level_id',
        'catalogNumber',
        'recordNumber',
        'recordedBy',
        'individualCount',
        'organismQuantity',
        'organismQuantityType',
        'sex',
        'lifeStage',
        'reproductiveCondition',
        'behavior',
        'substrate',
        'establishmentMeans',
        'preparations',
        'disposition',
        'associatedMedia',
        'associatedSequences',
        'associatedTaxa',
        'otherCatalogNumbers',
        'occurrenceRemarks',
        'organismID',
        'locationID',
        'taxonID',
        'identificationID',
    ];

    protected $casts = [
        'individualCount'   => 'integer',
        'organismQuantity'  => 'float',
    ];

    // ===================== Relaciones (sufijo Ref) =====================

    // A record_level (FK: record_level_id -> record_level.record_level_id)
    public function recordLevelRef()
    {
        return $this->belongsTo(\App\Models\RecordLevel::class, 'record_level_id', 'record_level_id');
    }

    public function identificationRef()
    {
        return $this->belongsTo(\App\Models\Identification::class, 'identificationID', 'identificationID');
    }
    
    public function measurements()
    {
        // FK textual en hija: measurementorfacts.id_occ_bd (varchar) → occurrence.id_occ_bd (int)
        return $this->hasMany(\App\Models\Measurementorfacts::class, 'id_occ_bd', 'id_occ_bd');
    }

    public function extractions()
    {
        // FK textual en hija: TblExtracciones.id_occ_bd (varchar)
        return $this->hasMany(\App\Models\Tblextractions::class, 'id_occ_bd', 'id_occ_bd');
    }

    // Vocabs de Occurrence
    public function organismQuantityTypeRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Organismquantitytype::class, 'organismQuantityType', 'oqtype_id');
    }

    public function sexRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Sex::class, 'sex', 'sex_id');
    }

    public function lifeStageRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Lifestage::class, 'lifeStage', 'lifestage_id');
    }

    public function reproductiveConditionRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Reproductivecondition::class, 'reproductiveCondition', 'reprocond_id');
    }

    public function establishmentMeansRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Establishmentmeans::class, 'establishmentMeans', 'estabmeans_id');
    }

    public function dispositionRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Disposition::class, 'disposition', 'disposition_id');
    }

    // relaciones con las otras tablas
    public function organismRef()
    {
        return $this->belongsTo(\App\Models\Organism::class, 'organismID', 'organismID');
    }
    
    public function locationRef()
    {
        return $this->belongsTo(\App\Models\Location::class, 'locationID', 'locationID');
    }

    public function taxonRef()
    {
        return $this->belongsTo(\App\Models\Taxon::class, 'taxonID', 'taxonID');
    }

    protected static function booted()
    {
        static::deleting(function (Occurrence $occ) {
            DB::transaction(function () use ($occ) {

                // 1) Hijas 1:N por id_occ_bd (strings en hijas)
                //    Borrar primero para evitar restricciones futuras
                $occ->measurements()->delete();
                $occ->extractions()->delete();

                // 2) 1:1 por columnas guardadas en occurrence (borrado "hacia arriba")
                if ($occ->identificationID) {
                    \App\Models\Identification::where('identificationID', $occ->identificationID)->delete();
                }

                if ($occ->record_level_id) {
                    \App\Models\RecordLevel::where('record_level_id', $occ->record_level_id)->delete();
                }

                // NOTA: si en el futuro algún vocab tuviese onDelete restrict,
                //       este orden evita conflictos.
            });
        });
    }

    // (Opcional) si luego creas modelos para MeasurementOrFacts / TblExtracciones,
    // te recomiendo revisar tipos (allí id_occ_bd es varchar) para evitar cast explícito.
}
