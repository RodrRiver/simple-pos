<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo {{ $sale->sale_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 15px; }
        .header h1 { font-size: 22px; margin-bottom: 5px; }
        .header p { font-size: 12px; color: #666; }
        .info { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 12px; }
        .info div { }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { text-align: left; border-bottom: 1px solid #ccc; padding: 8px 5px; font-size: 12px; color: #666; }
        td { padding: 8px 5px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals td { border: none; padding: 4px 5px; }
        .totals .total-row { font-size: 18px; font-weight: bold; border-top: 2px solid #333; padding-top: 8px; }
        .footer { text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ccc; font-size: 12px; color: #888; }
        .voided { color: red; font-size: 24px; font-weight: bold; text-align: center; margin: 10px 0; border: 3px solid red; padding: 10px; }
        @media print { body { padding: 10px; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #2563eb; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Imprimir</button>
        <a href="{{ route('sales.show', $sale) }}" style="margin-left: 10px; color: #666;">Volver</a>
    </div>

    <div class="header">
        <h1>{{ \App\Models\BusinessSetting::get('business_name', 'SimplePOS') }}</h1>
        <p>{{ \App\Models\BusinessSetting::get('business_address', '') }}</p>
        <p>Tel: {{ \App\Models\BusinessSetting::get('business_phone', '') }}</p>
    </div>

    @if($sale->isVoided())
    <div class="voided">ANULADA</div>
    @endif

    <div class="info">
        <div>
            <p><strong>Venta:</strong> {{ $sale->sale_number }}</p>
            <p><strong>Cajero:</strong> {{ $sale->user->name }}</p>
        </div>
        <div style="text-align: right;">
            <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ $sale->created_at->format('H:i:s') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-center">Cant.</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->product_price, 2) }}</td>
                <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td class="text-right">Subtotal:</td><td class="text-right" style="width:100px;">${{ number_format($sale->subtotal, 2) }}</td></tr>
        @if($sale->discount_amount > 0)
        <tr style="color:red;"><td class="text-right">Descuento:</td><td class="text-right">-${{ number_format($sale->discount_amount, 2) }}</td></tr>
        @endif
        <tr class="total-row"><td class="text-right">TOTAL:</td><td class="text-right">${{ number_format($sale->total, 2) }}</td></tr>
        <tr><td class="text-right">Pagado ({{ $sale->payment_method->label() }}):</td><td class="text-right">${{ number_format($sale->amount_paid, 2) }}</td></tr>
        @if($sale->change_amount > 0)
        <tr><td class="text-right">Cambio:</td><td class="text-right">${{ number_format($sale->change_amount, 2) }}</td></tr>
        @endif
    </table>

    <div class="footer">
        <p>{{ \App\Models\BusinessSetting::get('receipt_footer', '¡Gracias por su compra!') }}</p>
    </div>
</body>
</html>
