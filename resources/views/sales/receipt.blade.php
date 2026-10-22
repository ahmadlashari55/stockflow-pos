<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - {{ $sale->invoice_no }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; margin: 0 auto; padding: 20px 0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; font-size: 14px; }
        h2, h3, p { margin: 5px 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2>StockFlow Store</h2>
        <p>123 Main Street, Lahore</p>
        <p>Ph: 0300-0000000</p>
    </div>
    
    <div class="line"></div>
    
    <table>
        <tr><td>Invoice:</td><td class="text-right">{{ $sale->invoice_no }}</td></tr>
        <tr><td>Date:</td><td class="text-right">{{ $sale->created_at->format('d/m/Y h:i A') }}</td></tr>
        <tr><td>Customer:</td><td class="text-right">{{ $sale->customer->name ?? 'Walk-in' }}</td></tr>
    </table>
    
    <div class="line"></div>
    
    <table>
        @foreach($sale->items as $item)
        <tr>
            <td colspan="2">{{ $item->product->name }}</td>
        </tr>
        <tr>
            <td>{{ $item->quantity }} x {{ number_format($item->unit_price, 2) }}</td>
            <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </table>
    
    <div class="line"></div>
    
    <table>
        <tr><td>Subtotal:</td><td class="text-right">{{ number_format($sale->subtotal, 2) }}</td></tr>
        <tr><td>Discount:</td><td class="text-right">{{ number_format($sale->discount, 2) }}</td></tr>
        <tr><td><strong>Total:</strong></td><td class="text-right"><strong>{{ number_format($sale->total_amount, 2) }}</strong></td></tr>
        <tr><td>Paid:</td><td class="text-right">{{ number_format($sale->paid_amount, 2) }}</td></tr>
        <tr><td>Change:</td><td class="text-right">{{ number_format($sale->paid_amount - $sale->total_amount, 2) }}</td></tr>
    </table>
    
    <div class="line"></div>
    
    <div class="text-center mt-3">
        <p>Thank you for shopping!</p>
        <p>Powered by StockFlow POS</p>
    </div>
</body>
</html>