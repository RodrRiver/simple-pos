<x-layouts.app title="Inventario">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Inventario</h2>
        <a href="{{ route('inventory.history') }}" class="text-blue-600 hover:underline text-sm">Ver historial de movimientos</a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar producto..."
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <select name="stock_status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Todo el stock</option>
                <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Stock bajo</option>
                <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Sin stock</option>
            </select>
            <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Filtrar</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 font-medium">Producto</th>
                        <th class="px-5 py-3 font-medium">Categoría</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Alerta</th>
                        <th class="px-5 py-3 font-medium">Estado</th>
                        <th class="px-5 py-3 font-medium text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 {{ $product->stock === 0 ? 'bg-red-50/50' : ($product->isLowStock() ? 'bg-yellow-50/50' : '') }}">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-5 py-3 font-bold text-gray-800">{{ $product->stock }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $product->stock_alert_level }}</td>
                        <td class="px-5 py-3">
                            @if($product->stock === 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Agotado</span>
                            @elseif($product->isLowStock())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Bajo</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">OK</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <button onclick="openAdjust({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->stock }})"
                                class="text-blue-600 hover:underline text-sm">Ajustar</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-500">No hay productos.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-5 py-3 border-t border-gray-200">{{ $products->links() }}</div>
        @endif
    </div>

    {{-- Adjustment modal --}}
    <div id="adjustModal" class="fixed inset-0 bg-gray-900/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Ajustar stock</h3>
            <p class="text-sm text-gray-500 mb-4" id="adjustProductName"></p>
            <p class="text-sm text-gray-600 mb-4">Stock actual: <strong id="adjustCurrentStock"></strong></p>

            <form id="adjustForm" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select name="type" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                            <option value="addition">Entrada (agregar stock)</option>
                            <option value="subtraction">Salida (quitar stock)</option>
                            <option value="correction">Corrección (establecer cantidad)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                        <input type="number" name="quantity" min="1" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Razón (opcional)</label>
                        <input type="text" name="reason" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm" placeholder="Ej: Compra a proveedor">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Aplicar</button>
                        <button type="button" onclick="closeAdjust()" class="text-gray-500 hover:text-gray-700 text-sm">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAdjust(id, name, stock) {
            document.getElementById('adjustProductName').textContent = name;
            document.getElementById('adjustCurrentStock').textContent = stock;
            document.getElementById('adjustForm').action = '/inventario/' + id + '/ajustar';
            document.getElementById('adjustModal').classList.remove('hidden');
            document.getElementById('adjustModal').classList.add('flex');
        }
        function closeAdjust() {
            document.getElementById('adjustModal').classList.add('hidden');
            document.getElementById('adjustModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>
