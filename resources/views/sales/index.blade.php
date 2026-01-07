<!DOCTYPE html>
<html>
<head>
    <title>Daftar Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
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
        .btn {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 5px 0;
        }
        .btn-success {
            background: #28a745;
        }
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <h1>Daftar Transaksi Penjualan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('sales.create') }}" class="btn btn-success">+ Transaksi Baru</a>
    <a href="{{ route('customers.index') }}" class="btn">Master Pelanggan</a>
    <a href="{{ route('products.index') }}" class="btn">Master Barang</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->transaction_date->format('d/m/Y') }}</td>
                <td>{{ $sale->customer->name }}</td>
                <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst($sale->status) }}</td>
                <td>
                    <a href="{{ route('sales.show', $sale->id) }}" class="btn">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $sales->links() }}
</body>
</html>
