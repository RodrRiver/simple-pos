<?php

namespace App\Services;

use App\Enums\DiscountType;
use App\Enums\PaymentMethod;
use App\Enums\SaleStatus;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(private InventoryService $inventoryService) {}

    public function processSale(array $items, array $saleData): Sale
    {
        return DB::transaction(function () use ($items, $saleData) {
            $subtotal = 0;
            $saleItems = [];

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuficiente para {$product->name}. Disponible: {$product->stock}");
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $saleItems[] = [
                    'product' => $product,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_cost' => $product->cost,
                    'quantity' => $item['quantity'],
                    'discount_amount' => 0,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $discountAmount = 0;
            $discountType = null;
            if (!empty($saleData['discount_amount']) && $saleData['discount_amount'] > 0) {
                $discountType = DiscountType::from($saleData['discount_type'] ?? 'fixed');
                $discountAmount = $discountType === DiscountType::Percentage
                    ? round($subtotal * ($saleData['discount_amount'] / 100), 2)
                    : $saleData['discount_amount'];
            }

            $total = max(0, $subtotal - $discountAmount);
            $amountPaid = (float) $saleData['amount_paid'];
            $changeAmount = max(0, $amountPaid - $total);

            $sale = Sale::create([
                'user_id' => Auth::id(),
                'sale_number' => $this->generateSaleNumber(),
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'discount_type' => $discountType,
                'tax_amount' => 0,
                'total' => $total,
                'amount_paid' => $amountPaid,
                'change_amount' => $changeAmount,
                'payment_method' => PaymentMethod::from($saleData['payment_method'] ?? 'cash'),
                'notes' => $saleData['notes'] ?? null,
                'status' => SaleStatus::Completed,
            ]);

            foreach ($saleItems as $item) {
                $sale->items()->create([
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product_name'],
                    'product_price' => $item['product_price'],
                    'product_cost' => $item['product_cost'],
                    'quantity' => $item['quantity'],
                    'discount_amount' => $item['discount_amount'],
                    'subtotal' => $item['subtotal'],
                ]);

                $this->inventoryService->decrementStock($item['product'], $item['quantity'], $sale);
            }

            return $sale;
        });
    }

    public function voidSale(Sale $sale): Sale
    {
        return DB::transaction(function () use ($sale) {
            $sale->update([
                'status' => SaleStatus::Voided,
                'voided_at' => now(),
                'voided_by' => Auth::id(),
            ]);

            foreach ($sale->items as $item) {
                if ($item->product) {
                    $this->inventoryService->incrementStock($item->product, $item->quantity, $sale);
                }
            }

            return $sale->fresh();
        });
    }

    private function generateSaleNumber(): string
    {
        $today = now()->format('Ymd');
        $lastSale = Sale::where('sale_number', 'like', "V-{$today}-%")
            ->orderByDesc('sale_number')
            ->first();

        $sequence = 1;
        if ($lastSale) {
            $parts = explode('-', $lastSale->sale_number);
            $sequence = ((int) end($parts)) + 1;
        }

        return sprintf('V-%s-%04d', $today, $sequence);
    }
}
