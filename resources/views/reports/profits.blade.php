<x-layouts.app title="Reporte de Ganancias">
    <div class="flex items-center mb-6">
        <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h2 class="text-lg font-semibold text-gray-800">Reporte de Ganancias</h2>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Filtrar</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Ingresos</p>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($totals['revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Costos</p>
            <p class="text-2xl font-bold text-red-600">${{ number_format($totals['cost'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Ganancia</p>
            <p class="text-2xl font-bold text-green-600">${{ number_format($totals['profit'], 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                    <th class="px-5 py-3 font-medium">Producto</th>
                    <th class="px-5 py-3 font-medium text-center">Uds.</th>
                    <th class="px-5 py-3 font-medium text-right">Ingresos</th>
                    <th class="px-5 py-3 font-medium text-right">Costo</th>
                    <th class="px-5 py-3 font-medium text-right">Ganancia</th>
                    <th class="px-5 py-3 font-medium text-right">Margen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $product->product_name }}</td>
                    <td class="px-5 py-3 text-center text-gray-600">{{ $product->total_qty }}</td>
                    <td class="px-5 py-3 text-right">${{ number_format($product->revenue, 2) }}</td>
                    <td class="px-5 py-3 text-right text-gray-500">${{ number_format($product->total_cost, 2) }}</td>
                    <td class="px-5 py-3 text-right font-medium text-green-600">${{ number_format($product->profit, 2) }}</td>
                    <td class="px-5 py-3 text-right">
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $product->margin >= 40 ? 'bg-green-100 text-green-700' : ($product->margin >= 20 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ $product->margin }}%
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-500">Sin datos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
