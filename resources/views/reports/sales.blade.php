<x-layouts.app title="Reporte de Ventas">
    <div class="flex items-center mb-6">
        <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h2 class="text-lg font-semibold text-gray-800">Reporte de Ventas</h2>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Filtrar</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Total ventas</p>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($totals['revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Transacciones</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totals['count'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                    <th class="px-5 py-3 font-medium">Fecha</th>
                    <th class="px-5 py-3 font-medium text-center">Transacciones</th>
                    <th class="px-5 py-3 font-medium text-right">Ingresos</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($dailySales as $day)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                    <td class="px-5 py-3 text-center text-gray-600">{{ $day->count }}</td>
                    <td class="px-5 py-3 text-right font-medium">${{ number_format($day->revenue, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-5 py-10 text-center text-gray-500">Sin datos para el período seleccionado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
