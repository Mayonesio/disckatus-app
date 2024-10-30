<?php

namespace App\Enums;

enum ThrowLevel: string
{
    case NONE = 'none';
    case BASIC = 'basic';
    case INTERMEDIATE = 'intermediate';
    case MASTER = 'master';

    public function label(): string
    {
        return match($this) {
            self::NONE => 'No domino',
            self::BASIC => 'Básico',
            self::INTERMEDIATE => 'Intermedio',
            self::MASTER => 'Maestro',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::NONE => 'bg-gray-100 text-gray-600',
            self::BASIC => 'bg-blue-100 text-blue-800',
            self::INTERMEDIATE => 'bg-yellow-100 text-yellow-800',
            self::MASTER => 'bg-purple-100 text-purple-800',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::NONE => '✖',
            self::BASIC => '★',
            self::INTERMEDIATE => '★★',
            self::MASTER => '★★★',
        };
    }
}