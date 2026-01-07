<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjualan</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>Sistem Penjualan</h1>
        <div style="margin-top: 30px;">
            <a href="{{ route('sales.create') }}" style="padding: 15px 30px; background: blue; color: white; text-decoration: none; border-radius: 5px;">
                Buat Transaksi Baru
            </a>
            <a href="{{ route('sales.index') }}" style="padding: 15px 30px; background: green; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
                Lihat Daftar Transaksi
            </a>
        </div>
        <div style="margin-top: 30px;">
            <a href="{{ route('customers.index') }}" style="padding: 10px 20px; background: gray; color: white; text-decoration: none; border-radius: 5px;">
                Master Pelanggan
            </a>
            <a href="{{ route('products.index') }}" style="padding: 10px 20px; background: gray; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
                Master Barang
            </a>
        </div>
    </div>
</body>
</html>
