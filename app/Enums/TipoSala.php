<?php

namespace App\Enums;

enum TipoSala: string
{
    case BIDIMENSIONAL = "2D";
    case TRIDIMENSIONAL = "3D";
    case IMAX = "IMAX";

    public function getLabel(): string
    {
        return match ($this) {
             self::BIDIMENSIONAL => '2D',
             self::TRIDIMENSIONAL => '3D',
             self::IMAX => 'IMAX',
             default => ''
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
