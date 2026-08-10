<x-layouts.app title="Historial de Inventario">
    <div class="flex items-center mb-6">
        <a href="{{ route('inventory.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h2 class="text-lg font-semibold text-gray-800">Historial de Movimientos</h2>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <select name="product" class="px-3 py-2 border border-gray-300 rounded-lg text-sm flex-1">
                <option value="">Todos los productos</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ request('product') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
            <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Todos los tipos</option>
                <option value="addition" {{ request('type') === 'addition' ? 'selected' : '' }}>Entrada</option>
                <option value="subtraction" {{ request('type') === 'subtraction' ? 'selected' : '' }}>Salida</option>
                <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>Venta</option>
                <option value="void" {{ request('type') === 'void' ? 'selected' : '' }}>Anulación</option>
                <option value="correction" {{ request('type') === 'correction' ? 'selected' : '' }}>Corrección</option>
            </select>
            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Filtrar</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 font-medium">Fecha</th>
                        <th class="px-5 py-3 font-medium">Producto</th>
                        <th class="px-5 py-3 font-medium">Tipo</th>
                        <th class="px-5 py-3 font-medium">Cantidad</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Usuario</th>
                        <th class="px-5 py-3 font-medium">Razón</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($adjustments as $adj)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-600">{{ $adj->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $adj->product->name }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                {{ in_array($adj->type->value, ['addition', 'void']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $adj->type->label() }}
                            </span>
                        </td>
                        <td class="px-5 py-3 font-medium">{{ $adj->quantity }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $adj->previous_stock }} → {{ $adj->new_stock }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $adj->user->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $adj->reason ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-500">Sin movimientos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($adjustments->hasPages())
        <div class="px-5 py-3 border-t border-gray-200">{{ $adjustments->links() }}</div>
        @endif
    </div>
</x-layouts.app>
