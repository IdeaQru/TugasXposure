<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Customers
        Customer::create(['name' => 'John Doe', 'phone' => '081234567890']);
        Customer::create(['name' => 'Jane Smith', 'phone' => '081234567891']);

        // Seed Products
        Product::create(['name' => 'Laptop', 'price' => 5000000, 'stock' => 10]);
        Product::create(['name' => 'Mouse', 'price' => 50000, 'stock' => 50]);
        Product::create(['name' => 'Keyboard', 'price' => 150000, 'stock' => 30]);
    }
}
