<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
        <select name="category_id" id="category_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            <option value="">Sin categoría</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
    <textarea name="description" id="description" rows="2"
        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio de venta ($) *</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0" required
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">Costo ($) *</label>
        <input type="number" name="cost" id="cost" value="{{ old('cost', $product->cost ?? '') }}" step="0.01" min="0" required
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
        @error('cost') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock actual *</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
    <div>
        <label for="stock_alert_level" class="block text-sm font-medium text-gray-700 mb-1">Alerta de stock bajo</label>
        <input type="number" name="stock_alert_level" id="stock_alert_level" value="{{ old('stock_alert_level', $product->stock_alert_level ?? 5) }}" min="0" required
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku ?? '') }}"
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
    <div>
        <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Código de barras</label>
        <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode ?? '') }}"
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
</div>

<div>
    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
    @if(isset($product) && $product->image)
        <div class="mb-2">
            <img src="{{ Storage::url($product->image) }}" alt="" class="w-20 h-20 rounded-lg object-cover">
        </div>
    @endif
    <input type="file" name="image" id="image" accept="image/*"
        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>

<div class="flex items-center">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
        class="h-4 w-4 text-blue-600 border-gray-300 rounded">
    <label for="is_active" class="ml-2 text-sm text-gray-700">Activo</label>
</div>
