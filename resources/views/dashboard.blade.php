<x-layouts.app title="Dashboard">
    {{-- Welcome --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Hola, {{ auth()->user()->name }}</h2>
        <p class="text-gray-500 text-sm mt-0.5">Aquí tienes el resumen de hoy.</p>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">Hoy</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($todaySales->revenue, 2) }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Ventas del día</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $todaySales->count }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Transacciones</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($avgTicket, 2) }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Ticket promedio</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 {{ $lowStockCount > 0 ? 'bg-amber-100' : 'bg-gray-100' }} rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                @if($lowStockCount > 0)
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">Alerta</span>
                @endif
            </div>
            <p class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-gray-800' }}">{{ $lowStockCount }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Stock bajo</p>
        </div>
    </div>

    {{-- Quick action for cashiers --}}
    @if(!auth()->user()->isAdmin())
    <div class="mb-8">
        <a href="{{ route('pos.index') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-2xl font-semibold text-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg shadow-blue-500/20 active:scale-[0.99]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Ir a Punto de Venta
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Revenue chart --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-800">Ventas - Últimos 7 días</h3>
                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">Semanal</span>
            </div>
            <canvas id="revenueChart" height="200"></canvas>
        </div>

        {{-- Low stock alerts --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-800">Alertas de stock</h3>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('inventory.index') }}" class="text-xs text-blue-600 hover:underline">Ver todo</a>
                @endif
            </div>
            @if($lowStockProducts->isEmpty())
                <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm">Todo el stock está bien</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($lowStockProducts as $product)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100/80 transition-colors">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $product->category?->name ?? 'Sin categoría' }}</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg {{ $product->stock === 0 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $product->stock }} uds
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Recent sales --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-semibold text-gray-800">Ventas recientes</h3>
            <a href="{{ route('sales.index') }}" class="text-xs text-blue-600 hover:underline">Ver todas</a>
        </div>
        @if($recentSales->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-sm">No hay ventas registradas</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-3 font-medium text-gray-400 text-xs uppercase tracking-wider">No. Venta</th>
                            <th class="pb-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Fecha</th>
                            <th class="pb-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Cajero</th>
                            <th class="pb-3 font-medium text-gray-400 text-xs uppercase tracking-wider text-right">Total</th>
                            <th class="pb-3 font-medium text-gray-400 text-xs uppercase tracking-wider text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentSales as $sale)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3">
                                <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ $sale->sale_number }}</a>
                            </td>
                            <td class="py-3 text-gray-500">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 text-gray-500">{{ $sale->user->name }}</td>
                            <td class="py-3 text-right font-semibold text-gray-800">${{ number_format($sale->total, 2) }}</td>
                            <td class="py-3 text-center">
                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-lg {{ $sale->isVoided() ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ $sale->status->label() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Ventas ($)',
                            data: @json($chartData),
                            backgroundColor: 'rgba(59, 130, 246, 0.15)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleColor: '#94a3b8',
                                bodyColor: '#fff',
                                bodyFont: { weight: 'bold' },
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { callback: v => '$' + v, color: '#94a3b8', font: { size: 11 } },
                                grid: { color: '#f1f5f9' },
                                border: { display: false },
                            },
                            x: {
                                ticks: { color: '#94a3b8', font: { size: 11 } },
                                grid: { display: false },
                                border: { display: false },
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.app>
