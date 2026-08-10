<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\SaleService;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function __construct(private SaleService $saleService) {}

    public function index()
    {
        $products = Product::active()
            ->with('category')
            ->orderBy('name')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'stock' => $p->stock,
                'category_id' => $p->category_id,
                'category_name' => $p->category?->name,
                'barcode' => $p->barcode,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
            ]);

        $categories = Category::active()->orderBy('sort_order')->get(['id', 'name', 'color']);

        return view('pos.index', compact('products', 'categories'));
    }

    public function processSale(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,transfer',
            'amount_paid' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:fixed,percentage',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $sale = $this->saleService->processSale($validated['items'], $validated);
            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $sale->sale_number,
                'total' => $sale->total,
                'change' => $sale->change_amount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
