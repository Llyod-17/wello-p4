<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function transactions()
    {
        $transactions      = Transaction::latest()->get();
        $totalProducts     = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue      = Transaction::sum('total_amount');

        return view('admin.transactions', compact(
            'transactions',
            'totalProducts',
            'totalTransactions',
            'totalRevenue'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Status pesanan ' . $transaction->invoice_code . ' atas nama ' . $transaction->customer_name . ' berhasil diubah menjadi: ' . $request->status
        );
    }

    // =========================================================================
    // MATERI PERTEMUAN 9: MANAJEMEN PRODUK & UPLOAD FILE GAMBAR
    // =========================================================================

    // FUNGSI 3: Menampilkan Daftar Katalog Produk di Seller Center (P9)
    public function products()
    {
        $products = Product::latest()->get();
        return view('admin.products', compact('products'));
    }

    // FUNGSI 4: Menampilkan Formulir Tambah Produk Baru (P9)
    public function createProduct()
    {
        return view('admin.create_product');
    }

    // FUNGSI 5: Memvalidasi Input, Mengunggah File Foto, & Menyimpan Produk ke MySQL (P9)
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'price'       => 'required|numeric|min:100',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            $targetDir = public_path('assets/images');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $file->move($targetDir, $imageName);
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imageName,
        ]);

        return redirect('/admin/products')->with(
            'success',
            'Produk "' . $request->name . '" berhasil ditambahkan dan langsung tayang di etalase toko!'
        );
    }
}
