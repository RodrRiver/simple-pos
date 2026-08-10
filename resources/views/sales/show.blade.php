<x-layouts.app title="Venta {{ $sale->sale_number }}">
    <div class="max-w-3xl">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('sales.index') }}" class="text-gray-400 hover:text-gray-600 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="text-lg font-semibold text-gray-800">{{ $sale->sale_number }}</h2>
                <span class="ml-3 px-2 py-1 text-xs font-semibold rounded-full {{ $sale->isVoided() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                    {{ $sale->status->label() }}
                </span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('sales.receipt', $sale) }}" target="_blank" class="bg-blue-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-blue-700">PDF</a>
                <a href="{{ route('sales.thermal-receipt', $sale) }}" target="_blank" class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-xs font-medium hover:bg-gray-200">Térmica</a>
                @if(auth()->user()->isAdmin() && !$sale->isVoided())
                <form method="POST" action="{{ route('sales.void', $sale) }}" onsubmit="return confirm('¿Anular esta venta? Se restaurará el stock.')">
                    @csrf
                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-xs font-medium hover:bg-red-200">Anular</button>
                </form>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div><p class="text-xs text-gray-400">Fecha</p><p class="font-medium">{{ $sale->created_at->format('d/m/Y H:i') }}</p></div>
                <div><p class="text-xs text-gray-400">Cajero</p><p class="font-medium">{{ $sale->user->name }}</p></div>
                <div><p class="text-xs text-gray-400">Método de pago</p><p class="font-medium">{{ $sale->payment_method->label() }}</p></div>
                <div><p class="text-xs text-gray-400">Pagado</p><p class="font-medium">${{ number_format($sale->amount_paid, 2) }}</p></div>
            </div>
            @if($sale->isVoided())
            <div class="mt-4 bg-red-50 rounded-lg p-3 text-sm text-red-700">
                Anulada el {{ $sale->voided_at->format('d/m/Y H:i') }} por {{ $sale->voidedByUser?->name }}
            </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 font-medium">Producto</th>
                        <th class="px-5 py-3 font-medium text-center">Cant.</th>
                        <th class="px-5 py-3 font-medium text-right">Precio</th>
                        <th class="px-5 py-3 font-medium text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($sale->items as $item)
                    <tr>
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $item->product_name }}</td>
                        <td class="px-5 py-3 text-center text-gray-600">{{ $item->quantity }}</td>
                        <td class="px-5 py-3 text-right text-gray-600">${{ number_format($item->product_price, 2) }}</td>
                        <td class="px-5 py-3 text-right font-medium">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-gray-200">
                    <tr><td colspan="3" class="px-5 py-2 text-right text-gray-600">Subtotal</td><td class="px-5 py-2 text-right">${{ number_format($sale->subtotal, 2) }}</td></tr>
                    @if($sale->discount_amount > 0)
                    <tr><td colspan="3" class="px-5 py-2 text-right text-red-600">Descuento</td><td class="px-5 py-2 text-right text-red-600">-${{ number_format($sale->discount_amount, 2) }}</td></tr>
                    @endif
                    <tr class="font-bold text-lg"><td colspan="3" class="px-5 py-3 text-right">Total</td><td class="px-5 py-3 text-right">${{ number_format($sale->total, 2) }}</td></tr>
                    @if($sale->change_amount > 0)
                    <tr><td colspan="3" class="px-5 py-2 text-right text-gray-500">Cambio</td><td class="px-5 py-2 text-right text-gray-500">${{ number_format($sale->change_amount, 2) }}</td></tr>
                    @endif
                </tfoot>
            </table>
        </div>
    </div>
</x-layouts.app>
