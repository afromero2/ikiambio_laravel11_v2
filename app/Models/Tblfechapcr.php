<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblfechapcr extends Model
{
    protected $table = 'TblFechaPCR';
    protected $primaryKey = 'idFechaPCR';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idFechaPCR','amplificationDate', 'amplificationMethod', 'lugar_process', 'amplificationStaff', 'num_reacciones', 'volumen_finalRx', 'masterMix', 'clh20', 'buffer', 'bsa', 'mgcl', 'dntp', 'primer_F', 'primer_R', 'taq', 'adn', 'equipo_PCR', 'pre_c', 'pretiempo', 'pcr1_c', 'pcr1tiempo', 'pcr2_c', 'pcr2tiempo', 'pcr3_c', 'pcr3tiempo', 'post_c', 'post_tiempo', 'final_c', 'ciclos', 'imagenPCRAccessionURI', 'imagenPCR'];

    public function getRouteKeyName()
    {
        return 'idFechaPCR';
    }
}
