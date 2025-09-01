<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'eventID';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['parentEventID', 'eventDate', 'eventTime', 'year', 'month', 'day', 'habitat', 'samplingProtocol', 'fieldNotes', 'locationID', 'eventRemarks'];
}
