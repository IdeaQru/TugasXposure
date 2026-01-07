<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    protected $fillable = ['customer_id', 'transaction_date', 'total_amount', 'status'];

    protected $casts = [
        'transaction_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    // Relasi: 1 Transaksi -> 1 Pelanggan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi: 1 Transaksi -> Banyak Barang
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }

    // Method untuk create dengan detail dan update stock
    public static function createWithDetails($customerId, $items)
    {
        return DB::transaction(function () use ($customerId, $items) {
            $totalAmount = 0;

            // Hitung total amount
            foreach ($items as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            // Buat sale header (1 Transaksi -> 1 Pelanggan)
            $sale = self::create([
                'customer_id' => $customerId,
                'transaction_date' => now(),
                'total_amount' => $totalAmount,
                'status' => 'completed'
            ]);

            // Buat sale details (1 Transaksi -> Banyak Barang)
            foreach ($items as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                
                $sale->salesDetails()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal
                ]);

                // Update stock product (qty mempengaruhi stock)
                Product::find($item['product_id'])
                       ->decrement('stock', $item['quantity']);
            }

            return $sale->load('salesDetails.product', 'customer');
        });
    }
}
