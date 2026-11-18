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

        // ==========================================
        // DATA UNTUK GRAFIK & DIAGRAM ADMIN (Chart.js)
        // ==========================================
        // 1. Tren Omzet Harian (7 hari terakhir)
        $dailySales = Transaction::whereIn('status', ['Paid', 'Shipped'])
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('total', 'date')
            ->toArray();

        $chartDailyLabels = [];
        $chartDailyValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->translatedFormat('d M');
            $chartDailyLabels[] = $label;
            $chartDailyValues[] = (int) ($dailySales[$day] ?? 0);
        }

        // 2. Top 5 Produk Terlaris (Qty)
        $topProducts = Transaction::whereIn('status', ['Paid', 'Shipped'])
            ->selectRaw('product_name, SUM(quantity) as total_qty')
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $chartTopProductLabels = $topProducts->pluck('product_name')->toArray();
        $chartTopProductValues = $topProducts->pluck('total_qty')->map(fn($v) => (int)$v)->toArray();

        // 3. Distribusi Status Transaksi
        $statusCounts = Transaction::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $chartStatusLabels = ['Pending', 'Paid', 'Shipped', 'Cancelled'];
        $chartStatusValues = [
            (int) ($statusCounts['Pending'] ?? 0),
            (int) ($statusCounts['Paid'] ?? 0),
            (int) ($statusCounts['Shipped'] ?? 0),
            (int) ($statusCounts['Cancelled'] ?? 0),
        ];

        // 4. Distribusi Kurir Pengiriman
        $courierCounts = Transaction::selectRaw('courier, COUNT(*) as count')
            ->whereNotNull('courier')
            ->groupBy('courier')
            ->pluck('count', 'courier')
            ->toArray();

        $chartCourierLabels = array_keys($courierCounts);
        $chartCourierValues = array_values(array_map('intval', $courierCounts));

        return view('admin.transactions', compact(
            'transactions',
            'totalProducts',
            'pendingCount',
            'successCount',
            'totalRevenue',
            'statusFilter',
            'chartDailyLabels',
            'chartDailyValues',
            'chartTopProductLabels',
            'chartTopProductValues',
            'chartStatusLabels',
            'chartStatusValues',
            'chartCourierLabels',
            'chartCourierValues'
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
