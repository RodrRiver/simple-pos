<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo {{ $sale->sale_number }}</title>
    <style>
        @php $paperWidth = \App\Models\BusinessSetting::get('receipt_paper_size', 80); @endphp
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: {{ $paperWidth }}mm; margin: 0 auto; padding: 5mm; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .row { display: flex; justify-content: space-between; }
        .item-name { }
        .item-detail { display: flex; justify-content: space-between; padding-left: 10px; font-size: 11px; }
        .total-line { font-size: 16px; font-weight: bold; }
        table { width: 100%; }
        td { vertical-align: top; }
        .right { text-align: right; }
        @media screen {
            body { border: 1px dashed #ccc; margin: 20px auto; }
            .no-print { text-align: center; width: {{ $paperWidth }}mm; margin: 10px auto; }
        }
        @media print {
            body { width: auto; padding: 0; border: none; }
            .no-print { display: none; }
            @page { size: {{ $paperWidth }}mm auto; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding: 8px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; margin-bottom: 10px;">Imprimir</button>
    </div>

    <div class="center bold" style="font-size: 14px;">{{ \App\Models\BusinessSetting::get('business_name', 'SimplePOS') }}</div>
    <div class="center" style="font-size: 10px;">{{ \App\Models\BusinessSetting::get('business_address', '') }}</div>
    <div class="center" style="font-size: 10px;">Tel: {{ \App\Models\BusinessSetting::get('business_phone', '') }}</div>

    <div class="line"></div>

    <div class="row"><span>{{ $sale->sale_number }}</span><span>{{ $sale->created_at->format('d/m/Y H:i') }}</span></div>
    <div>Cajero: {{ $sale->user->name }}</div>

    <div class="line"></div>

    @foreach($sale->items as $item)
    <div class="item-name">{{ $item->product_name }}</div>
    <div class="item-detail">
        <span>{{ $item->quantity }} x ${{ number_format($item->product_price, 2) }}</span>
        <span>${{ number_format($item->subtotal, 2) }}</span>
    </div>
    @endforeach

    <div class="line"></div>

    <table>
        <tr><td>Subtotal:</td><td class="right">${{ number_format($sale->subtotal, 2) }}</td></tr>
        @if($sale->discount_amount > 0)
        <tr><td>Descuento:</td><td class="right">-${{ number_format($sale->discount_amount, 2) }}</td></tr>
        @endif
        <tr class="total-line"><td>TOTAL:</td><td class="right">${{ number_format($sale->total, 2) }}</td></tr>
        <tr><td>{{ $sale->payment_method->label() }}:</td><td class="right">${{ number_format($sale->amount_paid, 2) }}</td></tr>
        @if($sale->change_amount > 0)
        <tr><td>Cambio:</td><td class="right">${{ number_format($sale->change_amount, 2) }}</td></tr>
        @endif
    </table>

    <div class="line"></div>

    <div class="center" style="font-size: 11px; margin-top: 5px;">
        {{ \App\Models\BusinessSetting::get('receipt_footer', '¡Gracias por su compra!') }}
    </div>
</body>
</html>
