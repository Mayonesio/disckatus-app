<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerProfile extends Model
{
    protected $fillable = [
        'position',
        'jersey_number',
        'height',
        'gender',
        'experience_years',
        'speed_rating',
        'endurance_rating',
        'notes',
        'emergency_contact',
        'emergency_phone',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}