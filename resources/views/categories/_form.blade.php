<div>
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required
        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
    <textarea name="description" id="description" rows="2"
        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
        <input type="color" name="color" id="color" value="{{ old('color', $category->color ?? '#7EC8E3') }}"
            class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer">
    </div>
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0"
            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
</div>

<div class="flex items-center">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
        class="h-4 w-4 text-blue-600 border-gray-300 rounded">
    <label for="is_active" class="ml-2 text-sm text-gray-700">Activa</label>
</div>
