<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EventType;

class KaderisasiEvent extends Model
{
    protected $fillable = [
        'pac_id',
        'event_type',
        'name',
        'venue',
        'start_date',
        'end_date',
        'certificate_start_number',
        'certificate_format',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'event_type' => EventType::class,
    ];

    public function pac()
    {
        return $this->belongsTo(Pac::class);
    }

    public function kaders()
    {
        return $this->belongsToMany(Kader::class, 'kader_kaderisasi_event')->withPivot('certificate_number')->withTimestamps();
    }
}
