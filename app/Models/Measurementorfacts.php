<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurementorfacts extends Model
{
    protected $table = 'measurementorfacts'; // tal como en tu SQL
    protected $primaryKey = 'measurementID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'measurementID',
        'id_occ_bd',
        'measurementType',
        'measurementValue',
        'measurementAccuracy',
        'measurementUnit',
        'measurementDeterminedBy',
        'measurementDeterminedDate',
        'measurementMethod',
        'measurementRemarks',
    ];

    public function occurrence()
    {
        return $this->belongsTo(\App\Models\Occurrence::class, 'id_occ_bd', 'id_occ_bd');
    }
}
