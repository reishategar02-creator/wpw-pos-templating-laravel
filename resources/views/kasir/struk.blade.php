<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk {{ $transaction->transaction_number }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 280px; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        .right { text-align: right; }
        hr { border: none; border-top: 1px dashed #000; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .actions { margin-top: 12px; text-align: center; }
        @media print { .actions { display: none; } body { width: auto; } }
    </style>
</head>
<body>
    <div class="center">
        <strong>TOKO RETAIL MAKMUR</strong><br>
        Jl. Contoh No. 123, Jember<br>
        Telp. 0812-xxxx-xxxx
    </div>
    <hr>
    No. Transaksi: {{ $transaction->transaction_number }}<br>
    Tanggal: {{ $transaction->created_at->format('d-m-Y H:i') }}<br>
    Kasir: {{ $transaction->user->name }}<br>
    Pelanggan: {{ $transaction->customer_name ?: 'Umum' }}
    <hr>
    <table>
        @foreach($transaction->details as $item)
            <tr><td colspan="2">{{ $item->product_name }}</td></tr>
            <tr>
                <td>{{ $item->qty }} x {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
    <table>
        <tr><td>Subtotal</td><td class="right">{{ number_format($transaction->subtotal, 0, ',', '.') }}</td></tr>
        <tr><td>Diskon</td><td class="right">{{ number_format($transaction->discount, 0, ',', '.') }}</td></tr>
        <tr><td>Pajak</td><td class="right">{{ number_format($transaction->tax, 0, ',', '.') }}</td></tr>
        <tr><td>Biaya Lain</td><td class="right">{{ number_format($transaction->other_fee, 0, ',', '.') }}</td></tr>
    </table>
    <hr>
    <table>
        <tr><td><strong>TOTAL</strong></td><td class="right"><strong>{{ number_format($transaction->grand_total, 0, ',', '.') }}</strong></td></tr>
        <tr><td>Bayar ({{ strtoupper($transaction->payment_method) }})</td><td class="right">{{ number_format($transaction->paid_amount, 0, ',', '.') }}</td></tr>
        <tr><td>Kembali</td><td class="right">{{ number_format($transaction->change_amount, 0, ',', '.') }}</td></tr>
    </table>
    <hr>
    <div class="center">Terima kasih atas kunjungan Anda</div>

    <div class="actions">
        <button onclick="window.print()">Cetak Struk</button>
        <a href="{{ route('kasir.dashboard') }}">Transaksi Baru</a>
    </div>
</body>
</html>