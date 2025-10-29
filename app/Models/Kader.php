<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\KaderStatus;

class Kader extends Model
{
    protected $fillable = [
        'pac_id',
        'nia',
        'nik',
        'username',
        'email',
        'phone_number',
        'name',
        'place_of_birth',
        'date_of_birth',
        'hobby',
        'address',
        'village',
        'city',
        'province',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => KaderStatus::class,
    ];

    public function pac()
    {
        return $this->belongsTo(Pac::class);
    }

    public function kaderisasiEvents()
    {
        return $this->belongsToMany(KaderisasiEvent::class, 'kader_kaderisasi_event')->withPivot('certificate_number')->withTimestamps();
    }
}
