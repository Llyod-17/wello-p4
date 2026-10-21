<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('katalog', compact('products'));
    }

    public function show(string $id) {
        $product = Product::findOrFail($id);
        return view('detail', compact('product'));
    }

    public function checkout($id) {
        $product = Product::findOrFail($id);
        return view('checkout', compact('product'));
    }

    public function storeTransaction(Request $request) {
        $product = Product::findOrFail($request->product_id);

        $shipping_cost = 15000;
        if ($request->courier == 'J&T Express') {
            $shipping_cost = 20000;
        } elseif ($request->courier == 'SiCepat BEST') {
            $shipping_cost = 25000;
        }

        $subtotal = $product->price * $request->quantity;
        $total_amount = $subtotal + $shipping_cost;

        $invoice_code = 'INV-2026-' . rand(1000, 9999);

        $transaction = Transaction::create([
            'invoice_code' => $invoice_code,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'courier' => $request->courier,
            'quantity' => $request->quantity,
            'shipping_cost' => $shipping_cost,
            'total_amount' => $total_amount,
            'status' => 'Pending',
        ]);

        return redirect('/berhasil/' . $transaction->id);
    }

    public function success($id) {
        $transaction = Transaction::findOrFail($id);
        return view('berhasil', compact('transaction'));
    }
}
