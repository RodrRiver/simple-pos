<?php

namespace App\Enums;

enum DiscountType: string
{
    case Fixed = 'fixed';
    case Percentage = 'percentage';

    public function label(): string
    {
        return match ($this) {
            self::Fixed => 'Monto fijo',
            self::Percentage => 'Porcentaje',
        };
    }
}
