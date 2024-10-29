<?php

namespace App\Enums;

enum PlayerPosition: string
{
    case HANDLER = 'handler';
    case CUTTER = 'cutter';
    case BOTH = 'both';

    public function label(): string
    {
        return match($this) {
            self::HANDLER => 'Handler',
            self::CUTTER => 'Cutter',
            self::BOTH => 'Ambas',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::HANDLER => 'bg-blue-100 text-blue-800',
            self::CUTTER => 'bg-green-100 text-green-800',
            self::BOTH => 'bg-purple-100 text-purple-800',
        };
    }
}