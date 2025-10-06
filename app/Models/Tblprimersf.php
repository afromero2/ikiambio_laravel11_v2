<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblprimersf extends Model
{
    protected $table = 'TblPrimersF';
    protected $primaryKey = 'idPrimersf';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idPrimersf','genAbrev', 'genName', 'primerName', 'primerSequence', 'primerReferenceCitation', 'id_primerDirection', 'grupo_Taxonomico', 'region', 'tecnologia', 'proyecto_Tesis', 'longitud_Primer', 'Longitud_amplicon', 'gc', 'dnaMeltingPoint', 'annealing_Temperature', 'primerStaff', 'fecha_orden', 'proveedor'];
}
