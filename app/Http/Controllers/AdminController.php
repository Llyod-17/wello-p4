<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function transactions(Request $request)
    {
        $statusFilter = $request->query('status');
        $query = Transaction::query();

        if ($statusFilter && in_array($statusFilter, ['Pending', 'Paid', 'Shipped', 'Cancelled'])) {
            $query->where('status', $statusFilter);
        }

        $transactions      = $query->latest()->get();
        $totalProducts     = Product::count();
        $pendingCount      = Transaction::where('status', 'Pending')->count();
        $successCount      = Transaction::whereIn('status', ['Paid', 'Shipped'])->count();
        // Omzet bersih HANYA dari transaksi yang sudah Paid atau Shipped (Modul 6 UPRAK)
        $totalRevenue      = Transaction::whereIn('status', ['Paid', 'Shipped'])->sum('total_amount');

        return view('admin.transactions', compact(
            'transactions',
            'totalProducts',
            'pendingCount',
            'successCount',
            'totalRevenue',
            'statusFilter'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $updateData = ['status' => $request->status];
        if ($request->filled('tracking_number')) {
            $updateData['tracking_number'] = $request->tracking_number;
        }

        $transaction->update($updateData);

        return back()->with(
            'success',
            'Status pesanan ' . $transaction->invoice_code . ' berhasil diubah menjadi: ' . $request->status . ($request->filled('tracking_number') ? ' (Resi: ' . $request->tracking_number . ')' : '')
        );
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $code = $transaction->invoice_code;
        $transaction->delete();

        return back()->with('success', 'Pesanan ' . $code . ' berhasil dihapus dari Seller Center.');
    }

    // =========================================================================
    // MATERI PERTEMUAN 9 & UPRAK: MANAJEMEN PRODUK, STOK & KATEGORI
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

    // FUNGSI 5: Memvalidasi Input, Mengunggah File Foto, & Menyimpan Produk ke MySQL (P9 + Modul 6)
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:100',
            'stock'       => 'required|integer|min:0',
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
            'category'    => $request->category,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'image'       => $imageName,
        ]);

        return redirect('/admin/products')->with(
            'success',
            'Produk "' . $request->name . '" (Stok: ' . $request->stock . ') berhasil ditambahkan dan langsung tayang di etalase toko!'
        );
    }
}
