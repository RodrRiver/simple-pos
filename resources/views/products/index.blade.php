<x-layouts.app title="Productos">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Productos</h2>
        <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors text-center">
            + Nuevo Producto
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, SKU o código..."
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Filtrar</button>
            @if(request('search') || request('category'))
                <a href="{{ route('productos.index') }}" class="text-gray-500 hover:text-gray-700 text-sm self-center">Limpiar</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 font-medium">Producto</th>
                        <th class="px-5 py-3 font-medium">Categoría</th>
                        <th class="px-5 py-3 font-medium">Precio</th>
                        <th class="px-5 py-3 font-medium">Costo</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Estado</th>
                        <th class="px-5 py-3 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('productos.show', $product) }}" class="font-medium text-gray-800 hover:text-blue-600">{{ $product->name }}</a>
                                    @if($product->sku)<p class="text-xs text-gray-400">{{ $product->sku }}</p>@endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-5 py-3 font-medium">${{ number_format($product->price, 2) }}</td>
                        <td class="px-5 py-3 text-gray-600">${{ number_format($product->cost, 2) }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $product->stock === 0 ? 'bg-red-100 text-red-700' : ($product->isLowStock() ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right space-x-2">
                            <a href="{{ route('productos.edit', $product) }}" class="text-blue-600 hover:underline text-sm">Editar</a>
                            <form method="POST" action="{{ route('productos.destroy', $product) }}" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-500">No hay productos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-5 py-3 border-t border-gray-200">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</x-layouts.app>
