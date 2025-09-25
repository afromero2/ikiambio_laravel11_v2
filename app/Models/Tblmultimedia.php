<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblmultimedia extends Model
{
    protected $table = 'TblMultimedia';
    protected $primaryKey = 'idMultimedia';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idMultimedia',
        'id_occ_bd',
        'type',
        'format',
        'identifier',
        'title',
        'description',
        'created',
        'creator',
        'contributor',
        'publisher',
        'license',
    ];

    public function multimedia()
    {
        return $this->belongsTo(\App\Models\Occurrence::class, 'id_occ_bd', 'id_occ_bd');
    }
}
