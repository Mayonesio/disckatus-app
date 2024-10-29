<?php

namespace App\Enums;

enum ThrowType: string
{
    case BACKHAND = 'backhand';
    case FOREHAND = 'forehand';
    case HAMMER = 'hammer';
    case SCOOBER = 'scoober';
    case PUSH_PASS = 'push_pass';
    case THUMBER = 'thumber';
    case BLADE = 'blade';
    case ESPANTAGUIRIS = 'espantaguiris';
    case HIGH_RELEASE_BACKHAND = 'high_release_backhand';
    case LOW_RELEASE_FOREHAND = 'low_release_forehand';
    case LEFTY = 'lefty';
    case CHICKEN_WING = 'chicken_wing';
    case GRENADE = 'grenade';
    case PIZZA_TOSS = 'pizza_toss';
    case BLADE_SCOOBER = 'blade_scoober';
    case OVER_SHOULDER = 'over_shoulder';
    case BOUNCE_PASS = 'bounce_pass';
    case CORKSCREW = 'corkscrew';
    case AIR_BOUNCE = 'air_bounce';

    public function label(): string
    {
        return match($this) {
            self::BACKHAND => 'Backhand',
            self::FOREHAND => 'Forehand (Flick)',
            self::HAMMER => 'Hammer',
            self::SCOOBER => 'Scoober',
            self::PUSH_PASS => 'Push Pass',
            self::THUMBER => 'Thumber',
            self::BLADE => 'Blade',
            self::ESPANTAGUIRIS => 'Espantaguiris',
            self::HIGH_RELEASE_BACKHAND => 'High Release Backhand',
            self::LOW_RELEASE_FOREHAND => 'Low Release Forehand',
            self::LEFTY => 'Lefty Backhand/Forehand',
            self::CHICKEN_WING => 'Chicken Wing',
            self::GRENADE => 'Grenade',
            self::PIZZA_TOSS => 'The Pizza Toss',
            self::BLADE_SCOOBER => 'Blade Scoober',
            self::OVER_SHOULDER => 'Over-the-Shoulder Backhand',
            self::BOUNCE_PASS => 'Bounce Pass',
            self::CORKSCREW => 'Corkscrew',
            self::AIR_BOUNCE => 'Air Bounce',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::BACKHAND => 'Lanzamiento básico con reverso',
            self::FOREHAND => 'Lanzamiento de lado con muñeca',
            self::HAMMER => 'Lanzamiento sobre la cabeza vertical',
            // ... añadir descripciones para todos los lanzamientos
            default => ''
        };
    }
}