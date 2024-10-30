<?php

namespace App\Models;

use App\Enums\ThrowLevel;
use App\Enums\ThrowType;
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
        'is_active',
        'throw_levels',
        'throws_notes'
    ];

    protected $casts = [
        'throw_levels' => 'array',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setEmergencyPhoneAttribute($value)
    {
        $this->attributes['emergency_phone'] = $value ? 
            preg_replace('/[^0-9+]/', '', $value) : null;
    }

    public function getThrowLevel(ThrowType $throwType): ?ThrowLevel
    {
        $level = $this->throw_levels[$throwType->value] ?? null;
        return $level ? ThrowLevel::from($level) : ThrowLevel::NONE;
    }

    public function getMasteredThrows(): array
    {
        $mastered = [];
        foreach (ThrowType::cases() as $throwType) {
            $level = $this->getThrowLevel($throwType);
            if ($level === ThrowLevel::MASTER) {
                $mastered[] = [
                    'type' => $throwType,
                    'level' => $level,
                ];
            }
        }
        return $mastered;
    }

    public function getActiveThrows(): array
    {
        $active = [];
        foreach (ThrowType::cases() as $throwType) {
            $level = $this->getThrowLevel($throwType);
            if ($level !== ThrowLevel::NONE) {
                $active[] = [
                    'type' => $throwType,
                    'level' => $level,
                ];
            }
        }
        return $active;
    }
}