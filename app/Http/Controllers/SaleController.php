<?php

namespace App\Http\Controllers;

use App\Enums\SaleStatus;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(private SaleService $saleService) {}

    public function index(Request $request)
    {
        $query = Sale::with('user')->latest();

        if ($request->filled('search')) {
            $query->where('sale_number', 'like', "%{$request->search}%");
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sales = $query->paginate(20)->withQueryString();
        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['items', 'user', 'voidedByUser']);
        return view('sales.show', compact('sale'));
    }

    public function receipt(Sale $sale)
    {
        $sale->load(['items', 'user']);
        return view('sales.receipt', compact('sale'));
    }

    public function thermalReceipt(Sale $sale)
    {
        $sale->load(['items', 'user']);
        return view('sales.thermal-receipt', compact('sale'));
    }

    public function void(Sale $sale)
    {
        if ($sale->isVoided()) {
            return back()->with('error', 'Esta venta ya fue anulada.');
        }

        $this->saleService->voidSale($sale);
        return back()->with('success', "Venta {$sale->sale_number} anulada exitosamente. Stock restaurado.");
    }
}
