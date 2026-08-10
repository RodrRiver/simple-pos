<?php

namespace App\Http\Controllers;

use App\Enums\StockAdjustmentType;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockAdjustment;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(private InventoryService $inventoryService) {}

    public function index()
    {
        $query = Product::with('category');

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if (request('stock_status') === 'low') {
            $query->lowStock()->where('stock', '>', 0);
        } elseif (request('stock_status') === 'out') {
            $query->where('stock', 0);
        }

        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        $products = $query->active()->orderBy('stock')->paginate(30)->withQueryString();
        $categories = Category::active()->orderBy('sort_order')->get();

        return view('inventory.index', compact('products', 'categories'));
    }

    public function adjust(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|in:addition,subtraction,correction',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        $type = StockAdjustmentType::from($validated['type']);

        if ($type === StockAdjustmentType::Subtraction && $validated['quantity'] > $product->stock) {
            return back()->with('error', 'No hay suficiente stock para realizar esta salida.');
        }

        if ($type === StockAdjustmentType::Correction) {
            $this->inventoryService->adjustStock($product, $validated['quantity'], $type, $validated['reason']);
        } else {
            $this->inventoryService->adjustStock($product, $validated['quantity'], $type, $validated['reason']);
        }

        return back()->with('success', "Stock de {$product->name} ajustado exitosamente.");
    }

    public function history()
    {
        $query = StockAdjustment::with(['product', 'user'])->latest();

        if (request('product')) {
            $query->where('product_id', request('product'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        $adjustments = $query->paginate(30)->withQueryString();
        $products = Product::orderBy('name')->get(['id', 'name']);

        return view('inventory.history', compact('adjustments', 'products'));
    }
}
