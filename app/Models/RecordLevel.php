<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordLevel extends Model
{
    protected $table = 'record_level';
    protected $primaryKey = 'record_level_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // tu tabla no tiene created_at/updated_at

    protected $fillable = [
        'type','license','rightsHolder','accessRights','institutionID','collectionID',
        'institutionCode','collectionCode','ownerInstitutionCode','basisOfRecord',
        'modified','language','bibliographicCitation','references','datasetID',
        'datasetName','informationWithheld','dataGeneralizations',
    ];

    protected $casts = ['modified' => 'datetime'];


    // ================= Relaciones (FK local -> PK remota) =================
    public function typeRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Type::class, 'type', 'type_id');
    }

    public function licenseRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\License::class, 'license', 'license_id');
    }

    public function rightsHolderRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Rightsholder::class, 'rightsHolder', 'rightsHolder_id');
    }

    public function accessRightsRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Accessrights::class, 'accessRights', 'accessrights_id');
    }

    public function institutionIdRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Institutionid::class, 'institutionID', 'institution_id');
    }

    public function collectionIdRef()
    {
        return $this->belongsTo(
            \App\Models\Vocab\RecordLevel\Collectionid::class,
            'collectionID',   // FK en record_level (¡D mayúscula!)
            (new \App\Models\Vocab\RecordLevel\Collectionid)->getKeyName() // debería ser 'collection_id'
        );
    }

    public function institutionCodeRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Institutioncode::class, 'institutionCode', 'institutionCode_id');
    }

    public function collectionCodeRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Collectioncode::class, 'collectionCode', 'collectionCode_id');
    }

    public function ownerInstitutionCodeRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Ownerinstitutioncode::class,'ownerInstitutionCode',
        (new \App\Models\Vocab\RecordLevel\Ownerinstitutioncode)->getKeyName()
        );
    }

    public function basisOfRecordRef()
    {
        return $this->belongsTo(\App\Models\Vocab\RecordLevel\Basisofrecord::class, 'basisOfRecord', 'basisofrecord_id');
    }
}
