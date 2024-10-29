<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\PhoneHelper; // Añadir esta línea

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
        'is_active',
        'special_throws',
        'throw_ratings',
        'throws_notes',
        'hammer_rating',
        'scoober_rating',
        'push_pass_rating',
        'thumber_rating',
        'low_release_rating',
        'high_release_rating',
        'espantaguiris_rating',
        'blade_rating',
        'no_look_rating',
        'over_the_head_rating',
        'upside_down_rating'
    ];
    
    protected $casts = [
        'special_throws' => 'array',
        'throw_ratings' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setEmergencyPhoneAttribute($value)
    {
        $this->attributes['emergency_phone'] = PhoneHelper::format($value);
    }
}