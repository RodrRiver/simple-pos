<x-layouts.app title="Configuración">
    <div class="max-w-2xl">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Configuración</h2>

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Información del Negocio</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del negocio</label>
                        <input type="text" name="business_name" value="{{ $settings['business_name'] ?? '' }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="business_address" value="{{ $settings['business_address'] ?? '' }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="business_phone" value="{{ $settings['business_phone'] ?? '' }}"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                            <input type="email" name="business_email" value="{{ $settings['business_email'] ?? '' }}"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                        @if(!empty($settings['business_logo']))
                            <img src="{{ Storage::url($settings['business_logo']) }}" alt="Logo" class="w-16 h-16 rounded-lg object-contain mb-2">
                        @endif
                        <input type="file" name="business_logo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Recibos</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje en el pie del recibo</label>
                        <input type="text" name="receipt_footer" value="{{ $settings['receipt_footer'] ?? '' }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tamaño de papel térmico</label>
                        <select name="receipt_paper_size" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                            <option value="58" {{ ($settings['receipt_paper_size'] ?? '') == '58' ? 'selected' : '' }}>58mm</option>
                            <option value="80" {{ ($settings['receipt_paper_size'] ?? '') == '80' ? 'selected' : '' }}>80mm</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Impuestos y Moneda</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del impuesto</label>
                            <input type="text" name="tax_name" value="{{ $settings['tax_name'] ?? 'IVA' }}"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tasa (%)</label>
                            <input type="number" name="tax_rate" value="{{ $settings['tax_rate'] ?? '0' }}" step="0.01" min="0"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Símbolo de moneda</label>
                            <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                            <input type="text" name="currency_code" value="{{ $settings['currency_code'] ?? 'USD' }}"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Guardar Configuración
            </button>
        </form>
    </div>
</x-layouts.app>
