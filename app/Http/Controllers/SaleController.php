<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer', 'salesDetails')
                     ->latest()
                     ->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0'
        ]);

        try {
            // Gunakan method di Model untuk DB Transaction
            $sale = Sale::createWithDetails(
                $validated['customer_id'],
                $validated['items']
            );

            return redirect()->route('sales.show', $sale->id)
                             ->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'salesDetails.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        // Untuk ujian, edit bisa di-skip atau disabled
        return redirect()->route('sales.index')
                         ->with('info', 'Edit transaksi tidak diizinkan');
    }

    public function update(Request $request, Sale $sale)
    {
        // Untuk ujian, update bisa di-skip
        return redirect()->route('sales.index');
    }

    public function destroy(Sale $sale)
    {
        // Hapus sale akan otomatis hapus details karena onDelete cascade
        $sale->delete();

        return redirect()->route('sales.index')
                         ->with('success', 'Transaksi berhasil dihapus');
    }
}
