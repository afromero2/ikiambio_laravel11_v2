<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblregistroslaboratorio extends Model
{
    protected $table = 'TblRegistrosLaboratorio';
    protected $primaryKey = 'idRegistrosLaboratorio';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'idRegistrosLaboratorio',
        'idFechaPCR', 
        'idExtracciones', 
        'vol_ADN_PCR', 
        'amplificationSuccess', 
        'amplificationSuccessDetails', 
        'sampleDesignation', 
        'idPrimerF', 
        'idPrimerR', 
        'tecnologia_secuenciacion', 
        'consensusSequence', 
        'fechaSecuenciacion', 
        'sequencingStaff', 
        'ordenSecuenciacion', 
        'geneticAccessionNumber', 
        'geneticAccessionURI'
    ];

    /* public function extracciones()
    {
        return $this->belongsTo(Tblextractions::class, 'idRegistrosLaboratorio', 'idRegistrosLaboratorio');
    } */

    public function extraccion()
    {
        return $this->belongsTo(\App\Models\TblExtractions::class, 'idExtracciones', 'idExtracciones');
    }

    public function getRouteKeyName()
    {
        // Para que al pasar $modelo en route(), se use idRegistrosLaboratorio
        return 'idRegistrosLaboratorio';
    }


}
