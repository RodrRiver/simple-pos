<x-layouts.app title="{{ $product->name }}">
    <div class="max-w-3xl">
        <div class="flex items-center mb-6">
            <a href="{{ route('productos.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Categoría</p>
                        <p class="text-sm font-medium text-gray-700">{{ $product->category?->name ?? 'Sin categoría' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Precio</p>
                        <p class="text-sm font-medium text-gray-700">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Costo</p>
                        <p class="text-sm font-medium text-gray-700">${{ number_format($product->cost, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Margen</p>
                        <p class="text-sm font-medium text-green-600">${{ number_format($product->price - $product->cost, 2) }} ({{ $product->price > 0 ? round((($product->price - $product->cost) / $product->price) * 100) : 0 }}%)</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Stock</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $product->stock === 0 ? 'bg-red-100 text-red-700' : ($product->isLowStock() ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                            {{ $product->stock }} unidades
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Alerta de stock</p>
                        <p class="text-sm text-gray-700">{{ $product->stock_alert_level }} unidades</p>
                    </div>
                    @if($product->sku)
                    <div>
                        <p class="text-xs text-gray-400">SKU</p>
                        <p class="text-sm text-gray-700">{{ $product->sku }}</p>
                    </div>
                    @endif
                    @if($product->barcode)
                    <div>
                        <p class="text-xs text-gray-400">Código de barras</p>
                        <p class="text-sm text-gray-700">{{ $product->barcode }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stock adjustment history --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Historial de movimientos</h3>
            @if($product->stockAdjustments->isEmpty())
                <p class="text-sm text-gray-500 text-center py-4">Sin movimientos registrados.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b border-gray-200">
                                <th class="pb-2 font-medium">Fecha</th>
                                <th class="pb-2 font-medium">Tipo</th>
                                <th class="pb-2 font-medium">Cantidad</th>
                                <th class="pb-2 font-medium">Stock</th>
                                <th class="pb-2 font-medium">Usuario</th>
                                <th class="pb-2 font-medium">Razón</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($product->stockAdjustments as $adj)
                            <tr>
                                <td class="py-2 text-gray-600">{{ $adj->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                        {{ in_array($adj->type->value, ['addition', 'void']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $adj->type->label() }}
                                    </span>
                                </td>
                                <td class="py-2 font-medium">{{ $adj->quantity }}</td>
                                <td class="py-2 text-gray-600">{{ $adj->previous_stock }} → {{ $adj->new_stock }}</td>
                                <td class="py-2 text-gray-600">{{ $adj->user->name }}</td>
                                <td class="py-2 text-gray-500">{{ $adj->reason ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
