<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Collectionid extends Model
{
    protected $table = 'vocab_record_level_collectionID';
    protected $primaryKey = 'collection_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['collection_value', 'description'];
}
