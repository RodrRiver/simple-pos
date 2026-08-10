<?php

namespace App\Http\Controllers;

use App\Enums\SaleStatus;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $from = $request->filled('from') ? Carbon::parse($request->from) : Carbon::today()->subDays(30);
        $to = $request->filled('to') ? Carbon::parse($request->to) : Carbon::today();

        $dailySales = Sale::where('status', SaleStatus::Completed)
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totals = [
            'count' => $dailySales->sum('count'),
            'revenue' => $dailySales->sum('revenue'),
        ];

        return view('reports.sales', compact('dailySales', 'totals', 'from', 'to'));
    }

    public function products(Request $request)
    {
        $from = $request->filled('from') ? Carbon::parse($request->from) : Carbon::today()->subDays(30);
        $to = $request->filled('to') ? Carbon::parse($request->to) : Carbon::today();

        $products = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', SaleStatus::Completed)
            ->whereBetween('sales.created_at', [$from->startOfDay(), $to->endOfDay()])
            ->selectRaw('sale_items.product_name, SUM(sale_items.quantity) as total_qty, SUM(sale_items.subtotal) as total_revenue')
            ->groupBy('sale_items.product_name')
            ->orderByDesc('total_revenue')
            ->get();

        return view('reports.products', compact('products', 'from', 'to'));
    }

    public function profits(Request $request)
    {
        $from = $request->filled('from') ? Carbon::parse($request->from) : Carbon::today()->subDays(30);
        $to = $request->filled('to') ? Carbon::parse($request->to) : Carbon::today();

        $products = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', SaleStatus::Completed)
            ->whereBetween('sales.created_at', [$from->startOfDay(), $to->endOfDay()])
            ->selectRaw('sale_items.product_name, SUM(sale_items.quantity) as total_qty, SUM(sale_items.subtotal) as revenue, SUM(sale_items.product_cost * sale_items.quantity) as total_cost')
            ->groupBy('sale_items.product_name')
            ->orderByDesc('revenue')
            ->get()
            ->map(function ($p) {
                $p->profit = $p->revenue - $p->total_cost;
                $p->margin = $p->revenue > 0 ? round(($p->profit / $p->revenue) * 100, 1) : 0;
                return $p;
            });

        $totals = [
            'revenue' => $products->sum('revenue'),
            'cost' => $products->sum('total_cost'),
            'profit' => $products->sum('profit'),
        ];

        return view('reports.profits', compact('products', 'totals', 'from', 'to'));
    }
}
