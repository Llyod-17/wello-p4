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

    // ==========================================
    // TAMBAHAN FITUR ADMIN (CRUD & LKPPD P10)
    // ==========================================

    // Menampilkan halaman tambah produk
    public function create() {
        return view('admin.create_product');
    }

    // Menyimpan produk baru
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $filename);
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $filename,
        ]);

        return redirect('/admin/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit dengan pre-filled data
    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('admin.edit_product', compact('product'));
    }

    // Memperbarui produk (Conditional Upload & Unlink Foto Lama)
    public function updateProduct(Request $request, $id) {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        // Cek apakah admin mengunggah foto baru
        if ($request->hasFile('image')) {
            // Hapus file foto lama di folder jika ada (Unlink)
            if ($product->image && file_exists(public_path('assets/images/' . $product->image))) {
                unlink(public_path('assets/images/' . $product->image));
            }

            // Upload foto baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $filename);
            
            $product->image = $filename;
        }

        $product->save();

        return redirect('/admin/products')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk beserta file fisik fotonya di server
    public function deleteProduct($id) {
        $product = Product::findOrFail($id);

        // Hapus file foto dari folder public/assets/images/ (Unlink)
        if ($product->image && file_exists(public_path('assets/images/' . $product->image))) {
            unlink(public_path('assets/images/' . $product->image));
        }

        $product->delete();

        return redirect('/admin/products')->with('success', 'Produk berhasil dihapus!');
    }
}