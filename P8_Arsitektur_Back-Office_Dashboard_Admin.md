# PERTEMUAN 8

## ARSITEKTUR BACK-OFFICE (DASHBOARD ADMIN) & MANAJEMEN PESANAN MASUK (UPDATE DATA)

Guru Pengampu        : Sulthan Alawy Shihab, S.Kom

Alokasi Waktu        : 8 JP x 45 Menit (360 Menit)

Materi Pokok         : Dual-Layouting (admin.blade.php), Eloquent latest(), Aggregate
                     Query (count & sum), Eloquent update(), Flash Session

Model Belajar        : Quantum Learning (TANDUR)

Proyek Utama         : E-Commerce (Membangun Ruang Kendali Admin & Memproses
                     Status Pesanan Pembeli)

## A. TUJUAN PEMBELAJARAN

Setelah mengikuti praktikum ini, peserta didik diharapkan mampu:

   1. Memahami (C2) konsep pemisahan antarmuka Front-Store (halaman publik pembeli)
      dan Back-Office (halaman pengelola toko/admin) dalam arsitektur aplikasi e-
      commerce standar industri.
   2. Menganalisis (C4) penggunaan fungsi agregasi Eloquent ORM (count() dan sum())
      serta pengurutan waktu terbaru (latest()) untuk menyusun dashboard pemantauan
      transaksi secara real-time.
   3. Mendemonstrasikan (P3) pembuatan AdminController dan proses pembaruan baris
      data di MySQL menggunakan metode Eloquent update().
   4. Membangun (C6) halaman manajemen pesanan masuk ( /admin/transactions) yang
      mampu mengubah status pesanan dari Pending menjadi Paid (Lunas) atau Shipped
      (Dikirim) serta tersinkronisasi langsung dengan halaman Invoice milik pembeli.

## B. TUMBUHKAN (ENROLL) & ILUSTRASI PROJECT

"Dari Sisi Pembeli Menuju Ruang Kendali Pemilik Toko"

Pada Pertemuan 7, kalian telah menyelesaikan seluruh alur belanja dari sisi pembeli (Front-
Store). Saat pembeli mengisi formulir di halaman /checkout/{id} dan menekan tombol
konfirmasi, data pesanan mereka berhasil terekam ke dalam tabel transactions di MySQL
dan langsung mencetak halaman Invoice (/berhasil/{id}) dengan status awal Pending.

Sekarang, mari kita berpikir sebagai seorang System Engineer di perusahaan nyata. Ketika
ada 100 pembeli yang baru saja melakukan Checkout, bagaimana cara pemilik toko atau staf
admin mengecek pesanan yang masuk dan mengubah statusnya menjadi "Lunas" atau
"Sedang Dikirim"?

Apakah staf admin toko harus membuka aplikasi phpMyAdmin lalu mengedit tabel database
secara manual? Tentu saja dilarang keras! Memberikan akses phpMyAdmin kepada staf
operasional sangat berbahaya karena satu kesalahan klik dapat menghapus seluruh tabel
database perusahaan.

Di dunia industri, setiap aplikasi e-commerce wajib memiliki Back-Office (Dashboard
Admin). Hari ini, kita akan membangun halaman khusus Admin pada rute
/admin/transactions. Melalui halaman ini, Admin dapat melihat ringkasan omzet
penjualan otomatis, memantau daftar pesanan terbaru di dalam tabel yang rapi, dan menekan
tombol aksi untuk mengubah status pesanan dari Pending menjadi Paid (Lunas) hingga
Shipped (Dikirim)!

ILUSTRASI HASIL AKHIR PROJECT HARI INI:

Alur kerja yang kalian bangun hari ini akan menghubungkan tindakan Admin di belakang
layar langsung ke halaman Invoice milik pembeli:

🌐 LAYAR 1: DASHBOARD ADMIN (http://localhost:8000/admin/transactions)
===========================================================================
⚙️ PANEL ADMIN TOKO                                            [ 📦 Pesanan Masuk ] [
🌐 Lihat Toko ]
===========================================================================
[✅ NOTIFIKASI: Status pesanan INV-2026-4829 berhasil diperbarui menjadi:
Paid]

RINGKASAN BISNIS REAL-TIME (AGGREGATE QUERY):
+-----------------------+   +-----------------------+                +------------------

| TOTAL PRODUK ETALASE |       | TOTAL PESANAN MASUK       |   | TOTAL OMZET
PENJUALAN    |
|       6 Barang        |      |       3 Transaksi         |   |        Rp 645.000
|
+-----------------------+      +-----------------------+       +------------------

TABEL MANAJEMEN PESANAN MASUK (URUT DARI TERBARU):
+---------------+------------------+--------------------+-------------+----
| NO. INVOICE   | DATA PEMBELI     | PRODUK & EKSPEDISI | TOTAL BAYAR |
STATUS & AKSI      |
+---------------+------------------+--------------------+-------------+----
| INV-2026-4829 | Sulthan Alawy    | Jaket Premium (1x) | Rp 215.000 | [
💳 Paid (Lunas) ]|
| 25 Agu, 14:20 | 📞 081234567890        | 🚚 JNE Reguler         |               |
Ubah Status:      |
| [Lihat Nota↗] | 📍 Cibinong        | (+Rp 15.000)       |             |
[Lunas] [Dikirim] |
+---------------+------------------+--------------------+-------------+----
🌐 LAYAR 2: SINKRONISASI DI INVOICE PEMBELI
(http://localhost:8000/berhasil/1)
===========================================================================
🎉 TRANSAKSI BERHASIL TERCATAT!
Nomor Resi / Invoice : INV-2026-4829
Produk yang Dibeli   : Jaket Premium (1x)
Status Pesanan       : [ 💳 PEMBAYARAN LUNAS - PESANAN SEDANG DIKEMAS ] <-
- (Ikut Berubah!)
===========================================================================

## C. ALAMI & NAMAI (LANDASAN TEORI & PEMBAGIAN PERAN)

Sebelum menyentuh kode program, pahami 3 konsep utama pengelolaan sistem Back-Office
berikut:

#### 1. Pemisahan Master Layout (Front-Store vs Back-Office)

Pada Pertemuan 4, kalian telah membuat layouts/master.blade.php sebagai bingkai
utama halaman pembeli. Untuk halaman Admin, kita tidak menggunakan bingkai yang sama
agar pembeli dan pengelola tidak saling bingung. Kita akan membangun
layouts/admin.blade.php yang memiliki warna identitas berbeda dan navigasi khusus
pengelola toko.

#### 2. Fungsi Agregasi & Pengurutan Eloquent ( latest, count, sum)

Di halaman Dashboard Admin, pesanan yang baru saja masuk detik ini wajib tampil di baris
paling atas agar langsung terlihat oleh staf toko. Selain itu, komputer harus menghitung
otomatis total barang dan total uang yang masuk:

- Transaction::latest()->get() : Mengambil semua data transaksi diurutkan dari
       waktu terbaru (ORDER BY created_at DESC).
- Product::count() : Menghitung jumlah total baris produk di tabel products.
- Transaction::sum('total_amount') : Menjumlahkan seluruh angka pada kolom
       total_amount di tabel transactions.

#### 3. Mutasi Data Eloquent (update) & Flash Session (with)

Jika di Pertemuan 5–6 kalian mempelajari Read (all, findOrFail) dan di Pertemuan 7
mempelajari Create (Transaction::create), maka hari ini kalian mempraktikkan Update
($transaction->update([...])). Setelah data berhasil diubah di MySQL, Controller akan
mengembalikan Admin ke halaman tabel (return back()) sambil menitipkan pesan
notifikasi satu kali tampil menggunakan ->with('success', 'Pesan...').

#### 4. Literasi Syntax (Kamus Perintah Mesin)

          KODE PERINTAH                    FUNGSI TEKNIS /              ANALOGI
                                              FORMAL

 Transaction::latest()->get()             Mengambil seluruh       "Ambil semua nota
                                          rekaman tabel           pesanan dari gudang,
                                          diurutkan dari waktu    susun mulai dari nota
                                          pembuatan paling        yang baru saja masuk
                                          baru.                   hari ini di paling atas!"

 Transaction::sum('total_amount')         Menjumlahkan nilai      "Hitung total seluruh
                                          angka pada kolom        uang transaksi yang
                                          total_amount di         masuk di buku kasir
                                          MySQL.                  tanpa perlu kalkulator
                                                                  manual."

$transaction->update(['status'          Memperbarui nilai       "Hapus tulisan status
=> ...])
                                        kolom tertentu pada     'Pending' pada nota
                                        baris data yang         nomor ini, lalu ganti
                                        sedang dipilih di       dengan stempel baru!"
                                        database.

session('success')                      Menangkap dan           "Jika ada pesan sukses
                                        menampilkan pesan       dari Manajer
                                        notifikasi sementara    Controller, tampilkan
                                        (Flash Data) di layar   pita pengumuman hijau
                                        Blade.                  di atas layar."

### PEMBAGIAN TUGAS SPESIALISASI TIM:

- BACKEND DEVELOPER (Fokus Controller, Query Agregasi, & Logika
      Update):

      Membuat AdminController.php, menyusun query latest(), count(), dan sum()
      pada fungsi transactions(), merakit logika pembaruan status pada fungsi
      updateStatus(), serta mendaftarkan rute /admin/... di routes/web.php.

- UI/UX DESIGNER / FRONTEND (Fokus Layout Admin, Tabel Data, &
      Sinkronisasi Badge):

      Merakit bingkai layouts/admin.blade.php, membangun kartu statistik dan tabel
      daftar pesanan di admin/transactions.blade.php, serta memperbarui warna
      indikator status (Badge) di halaman berhasil.blade.php milik pembeli.

- PROJECT MANAGER (Fokus Quality Assurance & Validasi Dua Arah):

      Memastikan alur pembaruan data berjalan akurat dari tabel Admin ke database
      MySQL hingga ke layar Invoice pembeli, serta memimpin pengisian instrumen
      pengujian di LKPD.

## D. DEMONSTRASIKAN (PRAKTIKUM STEP-BY-STEP)

Pastikan Apache dan MySQL pada aplikasi Laragon sudah menyala hijau (Start All), lalu
buka folder proyek kalian di Visual Studio Code.

### LANGKAH 1: Membangun Bingkai Utama Admin ( layouts/admin.blade.php) - Oleh

Frontend

Kita buat bingkai halaman khusus Admin di dalam folder layouts agar tampilannya terpisah
secara profesional dari halaman pembeli.

   1. Di panel kiri VS Code, masuk ke folder resources/views/layouts/.
   2. Klik kanan pada folder layouts, pilih New File, dan beri nama: admin.blade.php.
   3. Ketik kode struktur Master Layout Admin berikut:

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Back-Office Admin - E-Commerce Kelas XII</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; background-color:
#f1f5f9;">

    <!-- 1. HEADER KHUSUS ADMIN (BACK-OFFICE) -->
    <header style="background-color: #0f172a; color: white; padding: 15px
50px; display: flex; justify-content: space-between; align-items: center;
border-bottom: 4px solid #0B5ED7;">
        <div>
            <span style="background-color: #0B5ED7; color: white; padding:
3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">
                BACK-OFFICE SYSTEM
            </span>
            <h2 style="margin: 5px 0 0 0;">⚙️ Ruang Kendali Admin
Toko</h2>
        </div>

        <nav style="display: flex; gap: 15px; align-items: center;">
            <a href="/admin/transactions" style="color: white; text-
decoration: none; font-weight: bold; background-color: #1e293b; padding:
10px 16px; border-radius: 6px; border: 1px solid #334155;">
                📦 Pesanan Masuk
            </a>
            <a href="/" target="_blank" style="color: #FFC107; text-
decoration: none; font-weight: bold; padding: 10px 16px; border: 1px solid
#FFC107; border-radius: 6px;">
                   🌐 Lihat Etalase Toko &nearr;

            </a>
        </nav>
    </header>

    <!-- 2. AREA KONTEN DINAMIS ADMIN -->
    <main style="padding: 35px 50px; min-height: 75vh;">
        @yield('konten_admin')
    </main>

    <!-- 3. FOOTER ADMIN -->
    <footer style="background-color: #cbd5e1; color: #334155; padding:
18px; text-align: center; font-size: 13px;">
```
        <p style="margin: 0; font-weight: bold;">Sistem Informasi Manajemen
E-Commerce - SMK Plus Pelita Nusantara</p>
    </footer>

</body>
</html>

### LANGKAH 2: Menambahkan Pintu Akses Admin di Header Toko

(layouts/master.blade.php) - Oleh Frontend

Agar kita mudah berpindah dari halaman toko ke halaman Admin saat pengujian, mari
```html
tambahkan satu tautan menuju Panel Admin di bagian navigasi master.blade.php.

   1. Buka file resources/views/layouts/master.blade.php.
   2. Perhatikan bagian <nav> di dalam <header>, lalu tambahkan tautan menuju
      /admin/transactions seperti berikut:

    <header style="background-color: #1a1a1a; color: white; padding: 15px
50px; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="margin: 0;">🛒 TOKO KELOMPOK KALIAN</h2>
        <nav style="margin-top: 5px;">
            <a href="/" style="color: white; text-decoration: none; margin-
left: 20px; font-weight: bold;">Katalog Produk</a>
            <!-- TAMBAHAN P8: Pintu menuju Dashboard Admin -->
```
            <a href="/admin/transactions" style="color: #FFC107; text-
decoration: none; margin-left: 20px; font-weight: bold;">⚙️ Panel
Admin</a>
        </nav>
    </header>

### LANGKAH 3: Membuat AdminController.php (Manajer Back-Office) - Oleh Backend

Dalam standar rekayasa perangkat lunak, logika halaman pembeli ( ProductController) dan
logika halaman pengelola toko (AdminController) dipisahkan agar kode program tetap rapi
```
dan mudah dirawat.

   1. Buka Terminal di VS Code, ketik perintah berikut lalu tekan Enter:

        Bash

        php artisan make:controller AdminController

   2. Buka file baru yang terbentuk di app/Http/Controllers/AdminController.php.
   3. Ketik kode lengkap untuk menampilkan statistik, daftar transaksi terbaru, serta fungsi
      pembaruan status pesanan berikut:

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // FUNGSI 1: Menampilkan Halaman Dashboard & Tabel Pesanan Masuk
    public function transactions()
    {
        // A. Mengambil seluruh pesanan diurutkan dari yang paling baru
masuk (latest)
        $transactions = Transaction::latest()->get();

          // B. Menghitung ringkasan bisnis otomatis (Aggregate Query)
          $totalProducts     = Product::count();
          $totalTransactions = Transaction::count();
          $totalRevenue      = Transaction::sum('total_amount');

        // C. Mengirimkan seluruh data ke view
resources/views/admin/transactions.blade.php
        return view('admin.transactions', compact(
            'transactions',
            'totalProducts',
            'totalTransactions',
            'totalRevenue'
        ));
    }

    // FUNGSI 2: Memperbarui Status Pesanan (Pending -> Paid / Shipped)
    public function updateStatus(Request $request, $id)
    {
        // A. Cari baris transaksi berdasarkan ID yang dikirim dari tabel
Admin
        $transaction = Transaction::findOrFail($id);

        // B. Perbarui (UPDATE) kolom 'status' di MySQL sesuai tombol yang
diklik Admin
        $transaction->update([
            'status' => $request->status
        ]);

        // C. Kembalikan ke halaman tabel Admin sambil mengirim notifikasi
Flash Session
```
        return back()->with(
            'success',
            'Status pesanan ' . $transaction->invoice_code . ' atas nama '
. $transaction->customer_name . ' berhasil diubah menjadi: ' . $request-
>status
        );
    }
}

### LANGKAH 4: Mendaftarkan Rute Admin di routes/web.php - Oleh Backend

Sekarang kita daftarkan jalur URL untuk membuka halaman Admin dan jalur POST untuk
memproses perubahan status pesanan.

   1. Buka file routes/web.php.
   2. Panggil AdminController di bagian atas dan tambahkan 2 rute baru di bagian bawah
      hingga kode lengkap routes/web.php menjadi seperti ini:

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController; // <-- [WAJIB P8] Panggil
AdminController

// =========================================================
// JALUR FRONT-STORE (SISI PEMBELI: P5, P6, P7)
// =========================================================
Route::get('/', [ProductController::class, 'index']);
Route::get('/detail/{id}', [ProductController::class, 'show']);

Route::get('/checkout/{id}', [ProductController::class, 'checkout']);
Route::post('/checkout/proses', [ProductController::class,
'storeTransaction']);
Route::get('/berhasil/{id}', [ProductController::class, 'success']);

// =========================================================
// JALUR BACK-OFFICE (SISI PENGELOLA / ADMIN: P8)
```
// =========================================================
// 1. Jalur menampilkan Dashboard & Tabel Pesanan Masuk
Route::get('/admin/transactions', [AdminController::class,
'transactions']);

// 2. Jalur memproses perubahan status pesanan (POST) berdasarkan ID
Transaksi
Route::post('/admin/transactions/{id}/status', [AdminController::class,
'updateStatus']);

### LANGKAH 5: Membangun Halaman Tabel Pesanan ( admin/transactions.blade.php)

- Oleh Frontend

Perhatikan di AdminController kita memanggil view('admin.transactions'). Artinya,
Laravel mencari file bernama transactions.blade.php di dalam folder
```html
resources/views/admin/.

   1. Di panel kiri VS Code, klik kanan pada folder resources/views/, pilih New Folder,
      dan beri nama admin.
   2. Klik kanan pada folder admin yang baru dibuat tersebut, pilih New File, dan beri
      nama transactions.blade.php.
   3. Ketik kode tampilan Kartu Statistik dan Tabel Manajemen Pesanan berikut:

@extends('layouts.admin')
@section('konten_admin')

    <!-- 1. KOTAK NOTIFIKASI FLASH SESSION (Muncul setelah Admin menekan
tombol ubah status) -->
    @if(session('success'))
        <div style="background-color: #d1e7dd; color: #0f5132; padding:
15px 20px; border-radius: 8px; border: 1px solid #badbcc; margin-bottom:
25px; font-weight: bold;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- 2. DERETAN KARTU RINGKASAN STATISTIK BISNIS -->

    <div style="display: flex; gap: 20px; margin-bottom: 30px;">

        <div style="flex: 1; background-color: white; padding: 20px 25px;
border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid
#0B5ED7;">
            <span style="font-size: 12px; color: #64748b; font-weight:
bold;">TOTAL PRODUK DI ETALASE</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color:
#0f172a;">{{ $totalProducts }} Produk</h2>
        </div>

        <div style="flex: 1; background-color: white; padding: 20px 25px;
border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid
#FFC107;">
            <span style="font-size: 12px; color: #64748b; font-weight:
bold;">TOTAL PESANAN MASUK</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color:
#0f172a;">{{ $totalTransactions }} Transaksi</h2>
        </div>

        <div style="flex: 1; background-color: white; padding: 20px 25px;
border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid
#28A745;">
            <span style="font-size: 12px; color: #64748b; font-weight:
bold;">TOTAL OMZET PENJUALAN</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color:
#28A745;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>

    </div>

    <!-- 3. TABEL MANAJEMEN PESANAN MASUK -->
    <div style="background-color: white; padding: 25px; border-radius: 8px;
border: 1px solid #cbd5e1;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #0f172a;
border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
              📋 Daftar Pesanan Pembeli (Diurutkan dari yang Terbaru)
          </h3>

          <table style="width: 100%; border-collapse: collapse; font-size:
14px;">
            <thead>
                <tr style="background-color: #f8fafc; color: #334155; text-
align: left; border-bottom: 2px solid #cbd5e1;">
                    <th style="padding: 12px;">No. Invoice & Waktu</th>
                    <th style="padding: 12px;">Identitas & Alamat
Pembeli</th>
                    <th style="padding: 12px;">Rincian Barang & Kurir</th>

                    <th style="padding: 12px;">Total Bayar</th>
                    <th style="padding: 12px; text-align: center;">Status
Pesanan</th>
                    <th style="padding: 12px; text-align: center;">Aksi
Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $item)
                    <tr style="border-bottom: 1px solid #e2e8f0;">

                        <!-- Kolom 1: Kode Invoice & Tautan Cek Nota
Pembeli -->
                        <td style="padding: 14px 12px; vertical-align:
top;">
                            <strong style="color: #0B5ED7; font-size:
15px;">{{ $item->invoice_code }}</strong>
                            <div style="font-size: 12px; color: #64748b;
margin: 4px 0 8px 0;">
                                {{ $item->created_at->format('d M Y, H:i')
}} WIB
                            </div>
                            <a href="/berhasil/{{ $item->id }}"
target="_blank" style="font-size: 12px; color: #0B5ED7; text-decoration:
none; font-weight: bold; background-color: #eff6ff; padding: 4px 8px;
border-radius: 4px; border: 1px solid #bfdbfe;">
                                Lihat Nota Pembeli &nearr;
                            </a>
                        </td>

                        <!-- Kolom 2: Data Penerima -->
                        <td style="padding: 14px 12px; vertical-align:
top;">
                             <strong style="color: #0f172a;">{{ $item-
>customer_name }}</strong>
                            <div style="font-size: 12px; color: #0f5132;
font-weight: bold; margin: 4px 0;">
                                📞 {{ $item->customer_phone }}
                            </div>
                            <div style="font-size: 12px; color: #475569;
max-width: 240px; line-height: 1.4;">
                                📍 {{ $item->customer_address }}
                            </div>
                        </td>

                        <!-- Kolom 3: Produk, Qty, & Kurir -->

                        <td style="padding: 14px 12px; vertical-align:
top;">
                            <strong style="color: #0f172a;">{{ $item-
>product_name }}</strong>
                            <div style="font-size: 12px; color: #475569;
margin-top: 4px;">
                                Jumlah Beli: <strong>{{ $item->quantity
}}x</strong>
                            </div>
                            <div style="font-size: 12px; color: #0B5ED7;
margin-top: 2px; font-weight: bold;">
                                🚚 {{ $item->courier }} (Ongkir Rp {{
number_format($item->shipping_cost, 0, ',', '.') }})
                            </div>
                        </td>

                        <!-- Kolom 4: Total Pembayaran -->
                        <td style="padding: 14px 12px; vertical-align: top;
font-weight: bold; color: #E63946; font-size: 15px;">
                            Rp {{ number_format($item->total_amount, 0,
',', '.') }}
                        </td>

                        <!-- Kolom 5: Indikator Warna Status (Badge
Dinamis) -->
                        <td style="padding: 14px 12px; vertical-align: top;
text-align: center;">
                            @if($item->status == 'Pending')
                                <span style="background-color: #fff3cd;
color: #856404; padding: 6px 12px; border-radius: 20px; font-weight: bold;
font-size: 12px; display: inline-block; border: 1px solid #ffeeba;">
                                    ⏳ Pending
                                </span>
                            @elseif($item->status == 'Paid')
                                <span style="background-color: #cfe2ff;
color: #084298; padding: 6px 12px; border-radius: 20px; font-weight: bold;
font-size: 12px; display: inline-block; border: 1px solid #b6d4fe;">
                                    💳 Paid (Lunas)
                                </span>
                            @elseif($item->status == 'Shipped')
                                <span style="background-color: #d1e7dd;
color: #0f5132; padding: 6px 12px; border-radius: 20px; font-weight: bold;
font-size: 12px; display: inline-block; border: 1px solid #badbcc;">
                                    🚚 Shipped (Dikirim)
                                </span>
                            @endif
                        </td>

                        <!-- Kolom 6: Formulir Tombol Aksi Update Status --
>
                        <td style="padding: 14px 12px; vertical-align: top;
text-align: center;">
                            <form action="/admin/transactions/{{ $item->id
}}/status" method="POST" style="display: flex; gap: 6px; justify-content:
center;">
                                @csrf

                                <button type="submit" name="status"
value="Paid" style="background-color: #0B5ED7; color: white; border: none;
padding: 7px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;
cursor: pointer;">
                                    Set Lunas
                                </button>

                                <button type="submit" name="status"
value="Shipped" style="background-color: #28A745; color: white; border:
none; padding: 7px 10px; border-radius: 4px; font-size: 12px; font-weight:
bold; cursor: pointer;">
                                    Set Dikirim
                                </button>

                                <button type="submit" name="status"
value="Pending" style="background-color: #6c757d; color: white; border:
none; padding: 7px 10px; border-radius: 4px; font-size: 12px; cursor:
pointer;">
                                    Reset
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
```
                    <tr>
                        <td colspan="6" style="text-align: center; padding:
40px; color: #64748b; font-weight: bold;">
                            Belum ada data pesanan yang masuk. Silakan
lakukan simulasi Checkout di halaman toko terlebih dahulu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

LANGKAH 6: Menyinkronkan Warna Status pada Halaman Invoice Pembeli
(berhasil.blade.php) - Oleh Frontend

Pada Pertemuan 7 lalu, baris Status Pesanan di dalam file
resources/views/berhasil.blade.php masih menggunakan warna kuning statis
(background-color: #fff3cd). Agar saat Admin menekan tombol "Set Lunas" atau "Set
Dikirim" tampilan di layar Invoice pembeli ikut berubah warna secara dinamis, mari kita
sempurnakan bagian status di berhasil.blade.php.

   1. Buka file resources/views/berhasil.blade.php.
   2. Cari baris <tr> yang menampilkan Status Pesanan, lalu ubah bagian <td> statusnya
      dengan percabangan @if / @elseif seperti berikut:

            <tr>
                <td style="padding: 8px 0; color: #666;">Status
Pesanan:</td>
                <td style="padding: 8px 0; text-align: right;">
                    @if($transaction->status == 'Pending')
                        <span style="background-color: #fff3cd; color:
#856404; padding: 5px 12px; border-radius: 4px; font-weight: bold; font-
size: 13px;">
                            ⏳ Pending (Menunggu Konfirmasi Admin)
                        </span>
                    @elseif($transaction->status == 'Paid')
```
                        <span style="background-color: #cfe2ff; color:
#084298; padding: 5px 12px; border-radius: 4px; font-weight: bold; font-
size: 13px;">
                            💳 Paid (Pembayaran Lunas - Sedang Dikemas)
                        </span>
                    @elseif($transaction->status == 'Shipped')
                        <span style="background-color: #d1e7dd; color:
#0f5132; padding: 5px 12px; border-radius: 4px; font-weight: bold; font-
size: 13px;">
                              🚚 Shipped (Pesanan Sedang Dikirim Kurir)
                          </span>
                      @endif
                  </td>
              </tr>

## E. ULANGI & RAYAKAN (PENGUJIAN QUALITY ASSURANCE)

Project Manager, pimpin anggota tim kalian untuk melakukan pengujian integrasi antara
halaman Admin dan halaman Pembeli!

   1. Pastikan php artisan serve menyala, lalu buka http://localhost:8000 di
      Google Chrome.
   2. Klik menu "⚙️ Panel Admin" di pojok kanan atas Header (atau ketik langsung
      http://localhost:8000/admin/transactions).
   3. Uji Akurasi Kartu Statistik: Periksa ketiga kartu di bagian atas. Pastikan jumlah
      Total Produk, Total Pesanan Masuk, dan Total Omzet Penjualan sesuai dengan
      jumlah data yang ada di tabel MySQL kalian.
   4. Uji Urutan Pesanan Baru (latest):
  - Klik tombol "🌐 Lihat Etalase Toko ↗" di pojok kanan atas halaman
             Admin.
  - Lakukan 1 transaksi pembelian baru sampai muncul halaman Invoice
             (/berhasil/{id}).
  - Kembali ke tab halaman Admin lalu Refresh browser. Pastikan pesanan yang
             baru saja kalian buat muncul di baris paling atas tabel Admin!
   5. Uji Perubahan Status & Sinkronisasi Nota Pembeli:
  - Pada baris pesanan paling atas di tabel Admin, klik tombol biru "Set Lunas".
  - Pastikan muncul notifikasi hijau di atas layar dan badge status berubah
             menjadi 💳 Paid (Lunas).
  - Klik tombol "Lihat Nota Pembeli ↗" pada kolom pertama baris tersebut.
             Pastikan di halaman Invoice pembeli (/berhasil/{id}), statusnya juga telah
             berubah menjadi biru (💳 Paid (Pembayaran Lunas - Sedang Dikemas))!
  - Ulangi dengan menekan tombol hijau "Set Dikirim" dan pastikan nota
               pembeli ikut berubah menjadi hijau (🚚 Shipped).

## F. PRAKTIK MANDIRI KELOMPOK (SIMULASI OPERASIONAL

TOKO)

Setelah fitur utama berjalan lancar, selesaikan misi operasional berikut bersama kelompok
kalian:

   1. Simulasi 3 Status Berbeda:

       Pastikan di dalam tabel /admin/transactions kelompok kalian terdapat minimal 3
       baris transaksi pembeli dengan variasi status yang berbeda:

  -    Transaksi ke-1 berstatus 🚚 Shipped (Dikirim).
  -    Transaksi ke-2 berstatus 💳 Paid (Lunas).
            oTransaksi ke-3 berstatus ⏳ Pending.
   2. Verifikasi Database MySQL: Buka http://localhost/phpmyadmin, masuk ke
      ecommerce_db $\rightarrow$ tabel transactions. Periksa kolom status dan
      updated_at untuk membuktikan bahwa perubahan tombol yang dilakukan di web
      benar-benar mengubah data fisik di dalam MySQL.
   3. Finalisasi LKPD:

       Project Manager memverifikasi seluruh hasil kerja tim dan memandu pengisian
       LKPD Pertemuan 8 di bawah ini.

## G. KESIMPULAN & MATERI SELANJUTNYA

Luar Biasa! Hari ini kalian telah berhasil membangun ruang kendali Back-Office
(Dashboard Admin) dan mempraktikkan proses Update Data dalam siklus CRUD. Pemilik
toko kini dapat memantau omzet penjualan secara otomatis dan memperbarui status pesanan
pembeli dengan sekali klik tanpa harus menyentuh phpMyAdmin.

Persiapan Selanjutnya (Pertemuan 9): Saat ini Admin sudah memiliki tabel manajemen
pesanan yang canggih. Namun, bagaimana jika toko kalian kedatangan barang dagangan
model baru? Di Pertemuan 5 lalu, kalian masih menginput produk secara kaku lewat
kodingan ProductSeeder.php. Pada Pertemuan 9, kita akan membangun halaman
Manajemen Katalog Produk Admin (Form Tambah Barang Baru & Upload File Foto
Produk Asli) langsung dari Dashboard Admin!

## H. LEMBAR KERJA PESERTA DIDIK (LKPD) - PERTEMUAN 8

### INSTRUMEN PENGUJIAN DASHBOARD ADMIN, AGGREGATE QUERY, &

UPDATE STATUS

### A. IDENTITAS PROYEK KELOMPOK

- Nama Merek / Toko : .........................................................................
- Sektor E-Commerce : .........................................................................
- Pembagian Peran Pengujian :

          1. Project Manager (QC Lead) : .........................................................................
          2. UI/UX Designer (Frontend) : .........................................................................
          3. Backend Developer (DB) : .........................................................................

### B. CHECKLIST KONFIGURASI BACK-OFFICE & CONTROLLER (Wajib dicentang

oleh Project Manager setelah melihat langsung pekerjaan tim)

 No Instruksi Kerja Fungsional (SOP)                                                        Status TTD
                                                                                                   PM

 1   Master Layout Admin: File layouts/admin.blade.php                                      []          ...............
     berhasil dibuat terpisah dari master.blade.php.

 2   Controller & Query: AdminController.php berhasil                                       []          ...............
     menjalankan fungsi latest(), count(), dan sum().

 3   Routing Admin: File web.php telah memiliki rute GET                                    []          ...............
     /admin/transactions dan POST
     /admin/transactions/{id}/status.

 4   Update & Sinkronisasi: Tombol ubah status di tabel Admin                               []          ...............
     berfungsi dan warna status di berhasil.blade.php ikut
     berubah.

### C. MATRIKS PENGUJIAN DASHBOARD & SINKRONISASI STATUS (QUALITY

ASSURANCE) (Eksekusi di peramban Google Chrome dan tandai status kelulusannya)

 Skenario Pengujian         Target yang Diharapkan (Expected Result)                               Status
 Sistem Terpadu                                                                                    Kelulusan

 Uji Akurasi Kartu     Angka Total Produk, Total Pesanan Masuk, dan                                [ ] PASS [ ]
 Statistik (Aggregate) Total Omzet Penjualan di halaman Admin sesuai                               FAIL
                       dengan isi tabel MySQL.

 Uji Urutan Waktu        Saat membuat 1 pesanan baru dari halaman            [ ] PASS [ ]
 Pesanan (latest)        Checkout, pesanan tersebut otomatis tampil di baris FAIL
                         paling atas tabel Admin.

 Uji Tombol Mutasi       Menekan tombol "Set Lunas" atau "Set Dikirim"         [ ] PASS [ ]
 Status (update)         berhasil mengubah badge status di tabel dan           FAIL
                         memunculkan notifikasi hijau.

 Uji Sinkronisasi        Saat status pesanan diubah oleh Admin, halaman        [ ] PASS [ ]
 Nota Pembeli            Invoice pembeli (/berhasil/{id}) ikut berubah         FAIL
                         status dan warnanya.

### D. DOKUMENTASI VALIDASI TANGKAPAN LAYAR (SCREENSHOT)

1. Bukti Halaman Dashboard & Tabel Pesanan Masuk ( /admin/transactions)

(Tempel di sini - Pastikan 3 Kartu Statistik di bagian atas dan minimal 3 baris pesanan
dengan status berbeda terlihat jelas)

2. Bukti Notifikasi Flash Session Saat Mengubah Status Pesanan

(Tempel di sini - Tampilkan layar sesaat setelah tombol "Set Lunas" atau "Set Dikirim" diklik
sehingga pita notifikasi hijau terlihat)

3. Bukti Sinkronisasi Perubahan Status di Halaman Invoice Pembeli ( /berhasil/{id})

(Tempel di sini - Tampilkan halaman Invoice pembeli yang statusnya sudah berubah menjadi
Paid / Shipped)

### E. JURNAL PEMECAHAN MASALAH ANALITIS (TROUBLESHOOTING)

Studi Kasus Arsitektur & Operasional E-Commerce: Pada AdminController.php, kita
menarik data pesanan menggunakan perintah Transaction::latest()->get(), berbeda
dengan saat menarik katalog produk di Pertemuan 5 yang menggunakan Product::all().
Diskusikan bersama tim kalian, mengapa pada halaman manajemen pesanan Admin kita
wajib menggunakan latest()? Apa dampak buruknya bagi pelayanan toko online jika

pesanan ditampilkan menggunakan all() ketika jumlah transaksi sudah mencapai ribuan
pesanan?

Jawab:

......................................................................................................................................................
...

                                                                                                         Mengetahui / Mengesahkan,

                                                                                    Guru Mata Pelajaran Pemrograman Web,

                                                                                             ( Sulthan Alawy Shihab, S.Kom )
