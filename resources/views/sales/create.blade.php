<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan Baru</title>
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
        .form-group {
            margin: 15px 0;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        select, input {
            padding: 8px;
            width: 100%;
            max-width: 300px;
        }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-danger {
            background: #dc3545;
        }
        input[type="number"] {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <h1>Form Transaksi Penjualan</h1>
    
    @if(session('error'))
        <div style="padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin: 10px 0;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" id="salesForm">
        @csrf
        
        <div class="form-group">
            <label>Pilih Pelanggan: *</label>
            <select name="customer_id" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                @endforeach
            </select>
        </div>

        <h3>Daftar Barang</h3>
        <table id="itemsTable">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="itemsBody">
                <tr class="item-row">
                    <td>
                        <select name="items[0][product_id]" class="product-select" required onchange="updatePrice(this, 0)">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock }}">
                                    {{ $product->name }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][price]" class="price-input" readonly style="max-width: 150px;">
                    </td>
                    <td>
                        <input type="number" name="items[0][quantity]" class="qty-input" min="1" value="1" required onchange="calculateSubtotal(0)">
                    </td>
                    <td>
                        <input type="text" class="subtotal-display" readonly style="max-width: 150px;">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeRow(this)">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn" onclick="addRow()">+ Tambah Barang</button>

        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border: 1px solid #ddd;">
            <h3>Total: Rp <span id="grandTotal">0</span></h3>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
            <a href="{{ route('sales.index') }}" class="btn" style="text-decoration: none; display: inline-block;">Batal</a>
        </div>
    </form>

    <script>
        let rowIndex = 1;
        const products = @json($products);

        function addRow() {
            const tbody = document.getElementById('itemsBody');
            const newRow = document.querySelector('.item-row').cloneNode(true);
            
            // Update name attributes dengan index baru
            newRow.querySelectorAll('select, input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${rowIndex}]`);
                }
                if (input.type !== 'button') {
                    input.value = '';
                }
            });
            
            // Update onchange events
            newRow.querySelector('.product-select').setAttribute('onchange', `updatePrice(this, ${rowIndex})`);
            newRow.querySelector('.qty-input').setAttribute('onchange', `calculateSubtotal(${rowIndex})`);
            
            tbody.appendChild(newRow);
            rowIndex++;
        }

        function removeRow(button) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                button.closest('tr').remove();
                updateGrandTotal();
            } else {
                alert('Minimal harus ada 1 barang!');
            }
        }

        function updatePrice(selectElement, index) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const row = selectElement.closest('tr');
            
            row.querySelector('.price-input').value = price || '';
            calculateSubtotal(index);
        }

        function calculateSubtotal(index) {
            const rows = document.querySelectorAll('.item-row');
            const row = rows[index];
            
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const subtotal = price * qty;
            
            row.querySelector('.subtotal-display').value = formatRupiah(subtotal);
            updateGrandTotal();
        }

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach((row, index) => {
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                total += price * qty;
            });
            
            document.getElementById('grandTotal').textContent = formatRupiah(total);
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Validasi form sebelum submit
        document.getElementById('salesForm').addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('.item-row');
            let hasProduct = false;
            
            rows.forEach(row => {
                const productSelect = row.querySelector('.product-select');
                if (productSelect.value) {
                    hasProduct = true;
                }
            });
            
            if (!hasProduct) {
                e.preventDefault();
                alert('Pilih minimal 1 produk!');
            }
        });
    </script>
</body>
</html>
