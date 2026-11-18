<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::query();

        // 1. Fitur Pencarian (LIKE) - Mencari di Nama dan Deskripsi
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // 2. Fitur Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        // 3. Fitur Pengurutan (orderBy)
        if ($request->query('sort') === 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($request->query('sort') === 'termahal') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest(); // Default: Produk terbaru
        }

        $products = $query->get();
        $categories = Product::whereNotNull('category')->distinct()->pluck('category');

        return view('katalog', compact('products', 'categories'));
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

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:30',
            'customer_address' => 'required|string|max:1000',
            'courier' => 'required|string',
            'quantity' => 'required|integer|min:1|max:' . max(1, $product->stock),
        ], [
            'quantity.max' => 'Jumlah pesanan melebihi sisa stok yang tersedia (' . $product->stock . ' pcs).',
        ]);

        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok produk tidak mencukupi untuk jumlah yang diminta.'])->withInput();
        }

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
            'user_id' => auth()->id(),
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

        // Pengurangan stok otomatis (Modul 5 UPRAK)
        $product->decrement('stock', $request->quantity);

        return redirect('/berhasil/' . $transaction->id);
    }

    public function success($id) {
        $transaction = Transaction::findOrFail($id);

        // Proteksi invoice: hanya pemilik transaksi atau admin
        $user = auth()->user();
        if ($transaction->user_id !== null && $user) {
            if ($user->id !== $transaction->user_id && !$user->isAdmin()) {
                abort(403, 'Anda tidak memiliki hak untuk melihat invoice transaksi ini.');
            }
        }

        return view('berhasil', compact('transaction'));
    }

    public function myOrders() {
        $transactions = Transaction::where('user_id', auth()->id())->latest()->get();
        return view('pesanan_saya', compact('transactions'));
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
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:100',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product->name = $request->name;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
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