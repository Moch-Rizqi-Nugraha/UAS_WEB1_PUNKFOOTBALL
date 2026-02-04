<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->take(8)->get();
        return view('marketplace.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('marketplace.show', compact('product'));
    }

    public function buy($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();
        $quantity = 1; // default 1, bisa diubah jika ada input jumlah

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Kurangi stok
        $product->decrement('stock', $quantity);

        // Simpan transaksi
        \App\Models\Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'item_name' => $product->name,
            'amount' => $product->price * $quantity,
            'status' => 'completed',
            'transaction_type' => 'purchase',
            'transaction_date' => now(),
            'transaction_data' => [
                'quantity' => $quantity,
                'price' => $product->price,
            ],
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Pembelian berhasil!');
    }
}
