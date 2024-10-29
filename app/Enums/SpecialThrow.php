<?php

namespace App\Enums;

enum SpecialThrow: string
{
    case HAMMER = 'hammer';
    case SCOOBER = 'scoober';
    case PUSH_PASS = 'push_pass';
    case THUMBER = 'thumber';
    case LOW_RELEASE = 'low_release';
    case HIGH_RELEASE = 'high_release';
    case ESPANTAGUIRIS = 'espantaguiris';
    case BLADE = 'blade';
    case NO_LOOK = 'no_look';
    case OVER_THE_HEAD = 'over_the_head';
    case UPSIDE_DOWN = 'upside_down';

    public function label(): string
    {
        return match($this) {
            self::HAMMER => 'Hammer',
            self::SCOOBER => 'Scoober',
            self::PUSH_PASS => 'Push Pass',
            self::THUMBER => 'Thumber',
            self::LOW_RELEASE => 'Low Release',
            self::HIGH_RELEASE => 'High Release',
            self::ESPANTAGUIRIS => 'Espantaguiris',
            self::BLADE => 'Blade',
            self::NO_LOOK => 'No Look',
            self::OVER_THE_HEAD => 'Over the Head',
            self::UPSIDE_DOWN => 'Upside Down',
        };
    }

    public function getMedalColor(int $rating): string
    {
        return match(true) {
            $rating >= 8 => '#FFD700', // Oro
            $rating >= 5 => '#C0C0C0', // Plata
            default => '#CD7F32',      // Bronce
        };
    }

    public function getMedalLevel(int $rating): array
    {
        return match(true) {
            $rating >= 8 => [
                'text' => 'Maestro',
                'classes' => 'bg-yellow-100 text-yellow-800'
            ],
            $rating >= 5 => [
                'text' => 'Avanzado',
                'classes' => 'bg-gray-100 text-gray-800'
            ],
            default => [
                'text' => 'Aprendiz',
                'classes' => 'bg-orange-100 text-orange-800'
            ],
        };
    }
}