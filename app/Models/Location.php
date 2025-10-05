<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'locationID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'locationID','id_INEC','higherGeographyID','continent','waterBody',
        'islandGroup','island','country','countryCode','stateProvince','county',
        'municipality','locality','verbatimLocality','verbatimElevation','verbatimDepth',
        'locationRemarks','decimalLatitude','decimalLongitude','geodeticDatum',
        'verbatimLatitude','verbatimLongitude','verbatimCoordinateSystem','verbatimSRS',
        'georeferencedBy','georeferencedDate','georeferenceVerificationStatus','georeferenceRemarks'
    ];

    protected $casts = [
        'decimalLatitude' => 'float',
        'decimalLongitude' => 'float',
        'georeferencedDate' => 'date:Y-m-d',
    ];

    // app/Models/Location.php
    public function continentRef()
    { 
        return $this->belongsTo(\App\Models\Vocab\Location\Continent::class, 'continent', 'continent_id'); 
    }
    
    public function verbatimSrsRef()
    { 
        return $this->belongsTo(\App\Models\Vocab\Location\VerbatimSrs::class, 'verbatimSRS', 'verbatimSRS_id'); 
    }
    
    public function georefStatusRef()
    { 
        return $this->belongsTo(\App\Models\Vocab\Location\GeorefStatus::class, 'georeferenceVerificationStatus', 'georef_status_id'); 
    }

    public function events()
    {
        // FK en event = locationID, PK local = locationID
        return $this->hasMany(Event::class, 'locationID', 'locationID');
    }

    protected static function booted()
    {
        static::deleting(function (Location $loc) {
            DB::transaction(function () use ($loc) {
                // Si usas SoftDeletes y quieres respetar forceDelete:
                if (method_exists($loc, 'isForceDeleting') && $loc->isForceDeleting()) {
                    $loc->events()->forceDelete();
                } else {
                    $loc->events()->delete();
                }
            });
        });
    }

}
