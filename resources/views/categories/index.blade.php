<x-layouts.app title="Categorías">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Categorías</h2>
        <a href="{{ route('categorias.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            + Nueva Categoría
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                    <th class="px-5 py-3 font-medium">Color</th>
                    <th class="px-5 py-3 font-medium">Nombre</th>
                    <th class="px-5 py-3 font-medium">Productos</th>
                    <th class="px-5 py-3 font-medium">Estado</th>
                    <th class="px-5 py-3 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="w-6 h-6 rounded-full border border-gray-200" style="background-color: {{ $category->color ?? '#ccc' }}"></div>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $category->products_count }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('categorias.edit', $category) }}" class="text-blue-600 hover:underline text-sm">Editar</a>
                        <form method="POST" action="{{ route('categorias.destroy', $category) }}" class="inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-gray-500">No hay categorías registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
