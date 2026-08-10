<x-layouts.app title="Ventas">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Historial de Ventas</h2>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="No. de venta..."
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm flex-1">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <select name="payment_method" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Todo método</option>
                <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Efectivo</option>
                <option value="card" {{ request('payment_method') === 'card' ? 'selected' : '' }}>Tarjeta</option>
                <option value="transfer" {{ request('payment_method') === 'transfer' ? 'selected' : '' }}>Transferencia</option>
            </select>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Todo estado</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completada</option>
                <option value="voided" {{ request('status') === 'voided' ? 'selected' : '' }}>Anulada</option>
            </select>
            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Filtrar</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 font-medium">No. Venta</th>
                        <th class="px-5 py-3 font-medium">Fecha</th>
                        <th class="px-5 py-3 font-medium">Cajero</th>
                        <th class="px-5 py-3 font-medium">Método</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Estado</th>
                        <th class="px-5 py-3 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-gray-50 {{ $sale->isVoided() ? 'opacity-60' : '' }}">
                        <td class="px-5 py-3 font-medium">
                            <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:underline">{{ $sale->sale_number }}</a>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $sale->user->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $sale->payment_method->label() }}</td>
                        <td class="px-5 py-3 font-medium {{ $sale->isVoided() ? 'line-through' : '' }}">${{ number_format($sale->total, 2) }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $sale->isVoided() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $sale->status->label() }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:underline text-sm">Ver</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-500">No hay ventas registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())
        <div class="px-5 py-3 border-t border-gray-200">{{ $sales->links() }}</div>
        @endif
    </div>
</x-layouts.app>
