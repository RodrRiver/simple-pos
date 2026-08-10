<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Enums\SaleStatus;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todaySales = Sale::where('status', SaleStatus::Completed)
            ->whereDate('created_at', $today)
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(total), 0) as revenue')
            ->first();

        $avgTicket = $todaySales->count > 0
            ? round($todaySales->revenue / $todaySales->count, 2)
            : 0;

        $lowStockCount = Product::active()->lowStock()->count();

        $recentSales = Sale::with('user')
            ->latest()
            ->take(10)
            ->get();

        $lowStockProducts = Product::active()
            ->lowStock()
            ->with('category')
            ->take(10)
            ->get();

        // Last 7 days revenue
        $weeklyRevenue = Sale::where('status', SaleStatus::Completed)
            ->where('created_at', '>=', $today->copy()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('revenue', 'date')
            ->toArray();

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($date)->format('d/m');
            $chartData[] = (float) ($weeklyRevenue[$date] ?? 0);
        }

        return view('dashboard', compact(
            'todaySales', 'avgTicket', 'lowStockCount',
            'recentSales', 'lowStockProducts',
            'chartLabels', 'chartData'
        ));
    }
}
