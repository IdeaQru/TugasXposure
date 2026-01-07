<!DOCTYPE html>
<html>
<head>
    <title>Create Sales</title>
</head>

<body>
    <h1> Form Transaksi Penjualan </h1>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
      <label> Pelanggan: </label>
        <select name="customer_id">
            @foreach($customers as $customer)
            <option value="{{ $customer->id }}"> {{ $customer->name }} </option>
            @endforeach
        </select>
        <h3> Daftar Produk </h3>
<div id = "items" > 
    <div class="item-row">
        <select name="items[0][product_id]">
            @foreach($products as $product)
            <option value="{{ $product->id }}"> {{ $product->name }} - {{ $product->price }} </option>
            @endforeach
        </select>
        <input type="number" name="items[0][quantity]" placeholder="Quantity" />
        <input type="text" name="subtotal" placeholder="Subtotal" readonly />
    </div>
</div>
<button type="submit"> Submit </button>
</form>    
</body>
</html>