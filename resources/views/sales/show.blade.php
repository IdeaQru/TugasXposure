<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f4f4f4;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Detail Transaksi #{{ $sale->id }}</h1>

    <div class="info-box">
        <p><strong>Tanggal:</strong> {{ $sale->transaction_date->format('d F Y') }}</p>
        <p><strong>Pelanggan:</strong> {{ $sale->customer->name }}</p>
        <p><strong>Telepon:</strong> {{ $sale->customer->phone }}</p>
        <p><strong>Status:</strong> {{ ucfirst($sale->status) }}</p>
    </div>

    <h3>Detail Barang</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->salesDetails as $detail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->product->name }}</td>
                <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="4" style="text-align: right;">TOTAL:</th>
                <th>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('sales.index') }}" class="btn">Kembali</a>
</body>
</html>
