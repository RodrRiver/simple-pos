<x-layouts.app title="Editar Producto">
    <div class="max-w-2xl">
        <div class="flex items-center mb-6">
            <a href="{{ route('productos.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-lg font-semibold text-gray-800">Editar: {{ $product->name }}</h2>
        </div>

        <form method="POST" action="{{ route('productos.update', $product) }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')
            @include('products._form')
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">Actualizar</button>
                <a href="{{ route('productos.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Cancelar</a>
            </div>
        </form>
    </div>
</x-layouts.app>
