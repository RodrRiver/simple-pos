<?php

namespace App\Enums;

enum StockAdjustmentType: string
{
    case Addition = 'addition';
    case Subtraction = 'subtraction';
    case Sale = 'sale';
    case Void = 'void';
    case Correction = 'correction';

    public function label(): string
    {
        return match ($this) {
            self::Addition => 'Entrada',
            self::Subtraction => 'Salida',
            self::Sale => 'Venta',
            self::Void => 'Anulación',
            self::Correction => 'Corrección',
        };
    }
}
