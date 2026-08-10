<?php

namespace App\Models;

use App\Enums\StockAdjustmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockAdjustment extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'type', 'quantity',
        'previous_stock', 'new_stock', 'reason',
        'reference_id', 'reference_type',
    ];

    protected function casts(): array
    {
        return [
            'type' => StockAdjustmentType::class,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
