<?php

namespace App\Services;

use App\Enums\StockAdjustmentType;
use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryService
{
    public function adjustStock(
        Product $product,
        int $quantity,
        StockAdjustmentType $type,
        ?string $reason = null,
        ?Model $reference = null
    ): StockAdjustment {
        $previousStock = $product->stock;

        $newStock = match ($type) {
            StockAdjustmentType::Addition, StockAdjustmentType::Void => $previousStock + $quantity,
            StockAdjustmentType::Subtraction, StockAdjustmentType::Sale => max(0, $previousStock - $quantity),
            StockAdjustmentType::Correction => $quantity,
        };

        $product->update(['stock' => $newStock]);

        return StockAdjustment::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'type' => $type,
            'quantity' => $type === StockAdjustmentType::Correction ? abs($newStock - $previousStock) : $quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'reason' => $reason,
            'reference_id' => $reference?->id,
            'reference_type' => $reference ? get_class($reference) : null,
        ]);
    }

    public function incrementStock(Product $product, int $quantity, ?Model $reference = null): void
    {
        $this->adjustStock($product, $quantity, StockAdjustmentType::Void, null, $reference);
    }

    public function decrementStock(Product $product, int $quantity, ?Model $reference = null): void
    {
        $this->adjustStock($product, $quantity, StockAdjustmentType::Sale, null, $reference);
    }
}
