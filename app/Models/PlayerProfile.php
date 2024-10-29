<?php

namespace App\Models;

use App\Enums\PlayerPosition;
use App\Enums\SpecialThrow;
use App\Helpers\PhoneHelper;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class PlayerProfile extends Model
{
    protected $fillable = [
        // Campos básicos
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

        // Estadísticas físicas
        'jumping_height',
        'throwing_distance',
        'preferred_throw',
        'games_played',
        'assists',
        'points_scored',
        'defensive_blocks',
        'weight',
        'wingspan',

        // Preferencias y habilidades
        'playing_preferences',
        'special_skills',

        // Lanzamientos
        'special_throws',
        'throw_ratings',
        'throws_notes',
    ];

    protected $casts = [
        'special_throws' => 'array',
        'throw_ratings' => 'array',
        'playing_preferences' => 'array',
        'is_active' => 'boolean',
        'weight' => 'decimal:2',
        'position' => PlayerPosition::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setEmergencyPhoneAttribute($value)
    {
        $this->attributes['emergency_phone'] = PhoneHelper::format($value);
    }

    // Nuevos métodos para manejar lanzamientos
    public function hasSpecialThrow(SpecialThrow $throw): bool
    {
        return in_array($throw->value, $this->special_throws ?? []);
    }

    public function getThrowRating(SpecialThrow $throw): int
    {
        $ratingKey = $throw->value . '_rating';
        return $this->$ratingKey ?? 0;
    }

    public function getMedalInfo(SpecialThrow $throw): array
    {
        $rating = $this->getThrowRating($throw);
        return [
            'name' => $throw->label(),
            'rating' => $rating,
            'color' => $throw->getMedalColor($rating),
            'level' => $throw->getMedalLevel($rating),
        ];
    }

    public function getAllMedals(): array
    {
        $medals = [];
        foreach ($this->special_throws ?? [] as $throwValue) {
            try {
                $throw = SpecialThrow::from($throwValue);
                $medals[] = $this->getMedalInfo($throw);
            } catch (InvalidArgumentException $e) {
                // Ignorar lanzamientos inválidos
                continue;
            }
        }
        return $medals;
    }

    public function getAvailableThrows(): array
    {
        return array_map(fn(SpecialThrow $throw) => [
            'value' => $throw->value,
            'label' => $throw->label(),
            'has_throw' => $this->hasSpecialThrow($throw),
            'rating' => $this->getThrowRating($throw),
        ], SpecialThrow::cases());
    }
}