<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblprimersr extends Model
{
    protected $table = 'TblPrimersR';
    protected $primaryKey = 'idPrimersr';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idPrimersr','genAbrev', 'genName', 'primerName', 'primerSequence', 'primerReferenceCitation', 'id_primerDirection', 'grupo_Taxonomico', 'region', 'tecnologia', 'proyecto_Tesis', 'longitud_Primer', 'Longitud_amplicon', 'gc', 'dnaMeltingPoint', 'annealing_Temperature', 'primerStaff', 'fecha_orden', 'proveedor'];
}
