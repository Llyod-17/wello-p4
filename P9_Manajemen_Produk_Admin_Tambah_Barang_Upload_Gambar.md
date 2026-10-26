# P9 — Manajemen Produk Admin: Tambah Barang & Upload Gambar

**Sumber:** PDF *P9 Manajemen Produk Admin - Tambah Barang Upload Gambar (Create File Storage)*  
**Pertemuan:** 9  
**Materi:** Multipart Form Data, File Upload (`move`), Server Validation (`validate`), dan Modern Seller Center UI.

---

> Dokumen ini merupakan konversi isi PDF ke Markdown. Pemisah halaman dipertahankan untuk memudahkan pencocokan dengan dokumen asli.

## Halaman 1

PERTEMUAN 9
SELLER CENTER KATALOG: FORM TAMBAH PRODUK, UPLOAD FILE
GAMBAR (enctype), & VALIDASI SERVER

Guru Pengampu : Sulthan Alawy Shihab, S.Kom
Alokasi Waktu : 8 JP x 45 Menit
Materi Pokok : Multipart Form Data, File Upload (move), Server Validation
(validate), Modern Seller Center UI
Model Belajar : Quantum Learning (TANDUR)
Proyek Utama : E-Commerce (Membangun Halaman Tambah Produk & Upload Foto
Asli

A. TUJUAN PEMBELAJARAN
Setelah mengikuti praktikum ini, peserta didik diharapkan mampu:
1. Memahami (C2) mekanisme pengiriman berkas fisik (gambar/foto) melalui protokol
HTTP menggunakan atribut wajib enctype="multipart/form-data".
2. Menganalisis (C4) aturan validasi sisi server ($request->validate()) untuk
menyaring tipe ekstensi gambar (jpg, jpeg, png, webp) dan membatasi ukuran
maksimal file agar server tidak penuh.
3. Mendemonstrasikan (P3) proses pemindahan file gambar dari memori sementara ke
direktori public/assets/images/ menggunakan penamaan unik berbasis waktu
(time()).
4. Membangun (C6) antarmuka Manajemen Produk Seller Center berstandar industri
(menggunakan tipografi modern Plus Jakarta Sans / Inter dan tata letak bersih ala
Tokopedia/Shopee Seller) yang langsung menyinkronkan produk baru ke etalase
depan.

B. TUMBUHKAN (ENROLL) & ILUSTRASI PROJECT

---

## Halaman 2

"Selamat Tinggal Seeder Kaku, Selamat Datang Seller Center Modern!"
Pada Pertemuan 8, kalian telah berhasil membangun ruang kendali Back-Office untuk
memantau omzet dan mengubah status pesanan pembeli. Namun, coba perhatikan bagaimana
cara kalian memasukkan 6 barang dagangan ke dalam toko selama ini. Di Pertemuan 5,
kalian masih mengetik data barang secara manual di dalam file kodingan
ProductSeeder.php lalu memindahkan file gambarnya satu per satu lewat Windows
Explorer.
Bayangkan jika pemilik toko di Tokopedia atau Shopee ingin mengunggah barang dagangan
baru setiap hari. Apakah mereka harus membuka VS Code dan menjalankan perintah
terminal php artisan migrate:fresh --seed? Tentu saja tidak! Apalagi perintah
migrate:fresh akan menghancurkan seluruh riwayat pesanan pembeli yang sudah susah
payah kita kumpulkan di Pertemuan 7 dan 8!
Hari ini, kita akan meningkatkan kualitas Back-Office kalian menjadi sekelas Tokopedia /
Shopee Seller Center. Kita akan menyempurnakan tipografi menggunakan font Plus Jakarta
Sans, menghilangkan kesan kaku pada tabel, dan membangun halaman Manajemen Produk
(/admin/products) lengkap dengan fitur Upload Foto Produk Asli langsung dari
peramban!
ILUSTRASI HASIL AKHIR PROJECT HARI INI:
🌐 URL BROWSER: http://localhost:8000/admin/products/create
===========================================================================
[ SELLER CENTER ] Daftar Pesanan Katalog Produk Lihat
Toko ↗
===========================================================================
Katalog Produk / Tambah Produk Baru

+--------------------------------------------------------------------------
| Informasi Produk & Media
|
| Pastikkan foto produk jernih dan deskripsi lengkap agar menarik minat
pembeli. |
+--------------------------------------------------------------------------
|
|
| Foto Produk Utama [Wajib] | Nama Produk [Wajib]
|
| +------------------------------+ | [ Asus ROG Strix G16 RTX 4060
] |
| | | |
|

---

## Halaman 3

| | [ Pilih File Foto ] | | Harga Satuan (Rp) [Wajib]
|
| | Format: JPG, PNG, WEBP | | [ Rp | 24500000
] |
| | Maksimal ukuran: 2 MB | |
|
| | | | Spesifikasi & Deskripsi Produk [Wajib]
|
| +------------------------------+ | [ Garansi Resmi 2 Tahun. RAM 16GB
DDR5... ] |
| | [
] |
| |
|
| | [ Batal ] [ Simpan &
Tampilkan ] |
+--------------------------------------------------------------------------

C. ALAMI & NAMAI (LANDASAN TEORI & PEMBAGIAN PERAN)
Sebelum menulis kode program, pahami 3 fondasi teknis pengelolaan file dan antarmuka
Seller Center berikut:
1. Rahasia Upload File di Web: enctype="multipart/form-data"
Secara bawaan, tag <form method="POST"> hanya mampu mengirimkan data berupa teks
biasa (seperti nama, alamat, atau angka harga). Jika kalian menaruh <input type="file">
di dalam form biasa tanpa menambahkan atribut enctype="multipart/form-data", maka
yang terkirim ke Controller hanyalah teks nama filenya saja, sedangkan wujud fisik
gambarnya tertinggal di komputer pengguna.
2. Penamaan File Unik (time()) & Pemindahan Fisik (move())
Saat pengguna mengunggah foto bernama sepatu.jpg, kita tidak boleh menyimpannya
begitu saja dengan nama sepatu.jpg. Mengapa? Karena jika besok admin mengunggah foto
barang lain yang kebetulan namanya juga sepatu.jpg, maka foto lama akan tertimpa dan
hilang! Solusi standarnya adalah menggabungkan angka detik saat ini (time()) dengan
ekstensi aslinya (contoh: 1756102938_sepatu.jpg), lalu memindahkannya ke folder
public/assets/images/.
3. Standar Desain UI/UX Marketplace Modern (Anti-Kaku)

---

## Halaman 4

Mengapa tampilan web buatan pemula sering terlihat kaku, sedangkan Tokopedia atau
Shopee terlihat sangat bersih dan profesional? Rahasianya terletak pada 4 aturan desain ini:
 Tipografi Modern: Jangan gunakan font Arial atau Times New Roman. Gunakan
font Plus Jakarta Sans atau Inter dari Google Fonts.
 Spasi & Ketebalan Font: Gunakan ketebalan 600 (Semi-Bold) atau 700 (Bold) untuk
judul dan harga, serta warna abu-abu lembut (#64748b) untuk teks keterangan.
 Sudut & Garis Halus: Gunakan garis tepi tipis (1px solid #e2e8f0) dengan sudut
membulat (border-radius: 10px) di atas latar belakang abu-abu sangat muda
(#f8fafc).
 Hindari Pemakaian Emoji Berlebihan: Gunakan label teks yang bersih dan tegas
layaknya aplikasi komersial sungguhan.
4. Literasi Syntax (Kamus Perintah Mesin)
KODE PERINTAH FUNGSI TEKNIS /
FORMAL
ANALOGI
(BAHASA
MANUSIA)
enctype="multipart/formdata"
Mengizinkan formulir HTML
memecah dan mengirim
berkas biner (foto/dokumen)
ke server.
"Gunakan truk
kargo khusus agar
barang fisik (foto)
bisa diangkut
bersama surat
jalan."
$request->validate([...]) Memeriksa kelengkapan dan
keabsahan input sebelum
diproses ke database.
"Petugas QC
gudang yang
menolak barang
masuk jika
ukurannya
kebesaran atau
formatnya salah."
$request->file('image')-
>move(...)
Memindahkan berkas yang
diunggah dari folder
"Angkat foto dari
truk pengiriman,
lalu pajang ke

---

## Halaman 5

sementara server ke folder
tujuan (public).
dalam etalase kaca
toko kita."
public_path('assets/images') Menunjuk alamat absolut
folder
public/assets/images di
dalam proyek Laravel.
"Titik koordinat rak
penyimpanan foto di
dalam gudang
utama aplikasi."
PEMBAGIAN TUGAS SPESIALISASI TIM:
 BACKEND DEVELOPER (Fokus Validasi Server, Upload File, & Insert
Produk): Menambahkan 3 fungsi baru pada AdminController.php (products,
createProduct, dan storeProduct), menyusun aturan validasi gambar,
memprogram logika move() ke folder public/assets/images, serta mendaftarkan
rutenya di routes/web.php.
 UI/UX DESIGNER / FRONTEND (Fokus Transformasi Desain Seller Center &
Form Upload): Memperbarui layouts/admin.blade.php dengan font Plus Jakarta
Sans dan navigasi bergaya Seller Center, membangun halaman daftar katalog admin
(admin/products.blade.php), serta merakit halaman formulir tambah produk
(admin/create_product.blade.php).
 PROJECT MANAGER (Fokus Quality Assurance, Uji Validasi File, &
Sinkronisasi): Menguji ketahanan form saat diisi file bukan gambar (misal file .pdf
atau ukuran di atas 2MB), memastikan file gambar benar-benar masuk ke folder
public/assets/images/ di VS Code, dan memverifikasi kemunculan produk baru
di halaman beranda pembeli (/).

D. DEMONSTRASIKAN (PRAKTIKUM STEP-BY-STEP)
Pastikan Apache dan MySQL pada aplikasi Laragon sudah menyala hijau (Start All), lalu
buka folder proyek kalian di Visual Studio Code.
LANGKAH 1: Menyempurnakan Layout Seller Center (layouts/admin.blade.php) -
Oleh Frontend

---

## Halaman 6

Kita perbarui bingkai Admin yang dibuat pada Pertemuan 8 agar menggunakan font Plus
Jakarta Sans, memiliki tampilan bersih sekelas Tokopedia/Shopee Seller Center, dan
memuat menu navigasi Katalog Produk.
1. Buka file resources/views/layouts/admin.blade.php.
2. Ganti seluruh isinya dengan kode berstandar Marketplace Seller Center berikut:
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Center - Panel Pengelola Toko</title>
<!-- Memanggil Font Standar Industri Startup Indonesia: Plus Jakarta
Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;5
00;600;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body {
font-family: 'Plus Jakarta Sans', -apple-system,
BlinkMacSystemFont, sans-serif;
margin: 0;
background-color: #f8fafc;
color: #0f172a;
-webkit-font-smoothing: antialiased;
}
.topbar {
background-color: #ffffff;
border-bottom: 1px solid #e2e8f0;
padding: 0 48px;
height: 68px;
display: flex;
justify-content: space-between;
align-items: center;
position: sticky;
top: 0;
z-index: 100;
}
.brand-area {
display: flex;
align-items: center;
gap: 12px;
}
.brand-badge {

---

## Halaman 7

background-color: #0f172a;
color: #ffffff;
font-size: 11px;
font-weight: 700;
padding: 5px 10px;
border-radius: 6px;
letter-spacing: 0.5px;
}
.brand-title {
font-size: 17px;
font-weight: 700;
color: #0f172a;
margin: 0;
}
.nav-menu {
display: flex;
gap: 8px;
align-items: center;
}
.nav-link {
text-decoration: none;
color: #475569;
font-size: 14px;
font-weight: 600;
padding: 9px 16px;
border-radius: 8px;
transition: all 0.15s ease;
}
.nav-link:hover {
background-color: #f1f5f9;
color: #0f172a;
}
.nav-link-store {
text-decoration: none;
color: #0B5ED7;
background-color: #eff6ff;
border: 1px solid #bfdbfe;
font-size: 13px;
font-weight: 600;
padding: 8px 16px;
border-radius: 8px;
margin-left: 12px;
}
.container-admin {
max-width: 1200px;
margin: 0 auto;
padding: 32px 24px;
min-height: calc(100vh - 130px);
}

---

## Halaman 8

.footer-admin {
background-color: #ffffff;
border-top: 1px solid #e2e8f0;
color: #64748b;
padding: 20px;
text-align: center;
font-size: 13px;
}
</style>
</head>
<body>

<!-- 1. TOPBAR SELLER CENTER -->
<header class="topbar">
<div class="brand-area">
<span class="brand-badge">SELLER CENTER</span>
<h1 class="brand-title">Portal Manajemen Toko</h1>
</div>

<nav class="nav-menu">
<a href="/admin/transactions" class="nav-link">Pesanan
Masuk</a>
<a href="/admin/products" class="nav-link">Katalog Produk</a>
<a href="/admin/products/create" class="nav-link" style="color:
#0B5ED7;">+ Tambah Produk</a>
<a href="/" target="_blank" class="nav-link-store">Lihat Toko
Depan &nearr;</a>
</nav>
</header>

<!-- 2. AREA KONTEN DINAMIS -->
<main class="container-admin">
@yield('konten_admin')
</main>

<!-- 3. FOOTER -->
<footer class="footer-admin">
Portal Seller Center &bull; Kompetensi Keahlian Rekayasa Perangkat
Lunak - SMK Plus Pelita Nusantara
</footer>

</body>
</html>

LANGKAH 2: Menambahkan Rute Manajemen Produk (routes/web.php) - Oleh
Backend

---

## Halaman 9

Kita tambahkan 3 jalur baru di bawah kelompok rute Admin pada file routes/web.php: satu
untuk melihat daftar barang di Seller Center, satu untuk membuka form tambah barang, dan
satu jalur POST untuk memproses unggahan foto beserta datanya.
1. Buka file routes/web.php.
2. Tambahkan 3 baris rute Pertemuan 9 di bagian bawah hingga kode lengkap
routes/web.php menjadi seperti berikut:
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

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
// JALUR BACK-OFFICE / SELLER CENTER (SISI ADMIN: P8 & P9)
// =========================================================
// Materi P8: Manajemen Pesanan Masuk
Route::get('/admin/transactions', [AdminController::class,
'transactions']);
Route::post('/admin/transactions/{id}/status', [AdminController::class,
'updateStatus']);

// Materi P9: Manajemen Katalog Produk & Upload Gambar
Route::get('/admin/products', [AdminController::class, 'products']);
Route::get('/admin/products/create', [AdminController::class,
'createProduct']);
Route::post('/admin/products/store', [AdminController::class,
'storeProduct']);

LANGKAH 3: Merakit Logika Upload Gambar & Validasi di AdminController.php -
Oleh Backend
Sekarang kita tambahkan fungsi products(), createProduct(), dan storeProduct() ke
dalam AdminController.php.

---

## Halaman 10

1. Buka file app/Http/Controllers/AdminController.php.
2. Tepat di bawah fungsi updateStatus() yang kalian buat pada Pertemuan 8,
tambahkan ketiga fungsi baru ini (perhatikan kode lengkapnya di bawah):
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
// FUNGSI 1: Menampilkan Halaman Dashboard & Tabel Pesanan Masuk (P8)
public function transactions()
{
$transactions = Transaction::latest()->get();
$totalProducts = Product::count();
$totalTransactions = Transaction::count();
$totalRevenue = Transaction::sum('total_amount');

return view('admin.transactions', compact(
'transactions',
'totalProducts',
'totalTransactions',
'totalRevenue'
));
}

// FUNGSI 2: Memperbarui Status Pesanan (P8)
public function updateStatus(Request $request, $id)
{
$transaction = Transaction::findOrFail($id);
$transaction->update([
'status' => $request->status
]);

return back()->with(
'success',
'Status pesanan ' . $transaction->invoice_code . ' atas nama '
. $transaction->customer_name . ' berhasil diubah menjadi: ' . $request-
>status
);
}

//
=========================================================================

---

## Halaman 11

// MATERI PERTEMUAN 9: MANAJEMEN PRODUK & UPLOAD FILE GAMBAR
//
=========================================================================

// FUNGSI 3: Menampilkan Daftar Katalog Produk di Seller Center (P9)
public function products()
{
// Mengambil seluruh produk diurutkan dari yang terbaru ditambahkan
$products = Product::latest()->get();
return view('admin.products', compact('products'));
}

// FUNGSI 4: Menampilkan Formulir Tambah Produk Baru (P9)
public function createProduct()
{
return view('admin.create_product');
}

// FUNGSI 5: Memvalidasi Input, Mengunggah File Foto, & Menyimpan
Produk ke MySQL (P9)
public function storeProduct(Request $request)
{
// A. Validasi ketahanan data dan keamanan file gambar (Maksimal
2MB / 2048 KB)
$request->validate([
'name' => 'required|string|max:150',
'price' => 'required|numeric|min:100',
'description' => 'required|string',
'image' =>
'required|image|mimes:jpeg,png,jpg,webp|max:2048',
]);

// B. Proses penamaan unik dan pemindahan file foto ke folder
public/assets/images
$imageName = null;
if ($request->hasFile('image')) {
$file = $request->file('image');
// Membuat nama unik: gabungan detik saat ini + nama asli file
(tanpa spasi)
$imageName = time() . '_' . str_replace(' ', '_', $file-
>getClientOriginalName());
// Pindahkan fisik file ke folder public/assets/images
$file->move(public_path('assets/images'), $imageName);
}

// C. Simpan baris data produk baru ke tabel products di MySQL
Product::create([
'name' => $request->name,
'price' => $request->price,

---

## Halaman 12

'description' => $request->description,
'image' => $imageName,
]);

// D. Arahkan kembali ke halaman Daftar Produk Admin dengan
notifikasi sukses
return redirect('/admin/products')->with(
'success',
'Produk "' . $request->name . '" berhasil ditambahkan dan
langsung tayang di etalase toko!'
);
}
}

LANGKAH 4: Membangun Halaman Daftar Produk Seller Center
(admin/products.blade.php) - Oleh Frontend
Kita buat halaman daftar produk di ruang Admin yang menampilkan foto thumbnail barang,
harga format Rupiah, cuplikan deskripsi, dan tombol menuju form tambah produk.
1. Di panel kiri VS Code, klik kanan pada folder resources/views/admin/, pilih New
File, dan beri nama: products.blade.php.
2. Ketik kode tampilan daftar produk bergaya Seller Center berikut:
@extends('layouts.admin')
@section('konten_admin')

<!-- 1. NOTIFIKASI BERHASIL TAMBAH PRODUK -->
@if(session('success'))
<div style="background-color: #ecfdf5; color: #065f46; padding:
14px 18px; border-radius: 10px; border: 1px solid #a7f3d0; margin-bottom:
24px; font-size: 14px; font-weight: 600;">
{{ session('success') }}
</div>
@endif

<!-- 2. HEADER HALAMAN & TOMBOL TAMBAH PRODUK -->
<div style="display: flex; justify-content: space-between; align-items:
center; margin-bottom: 24px;">
<div>
<h2 style="margin: 0; font-size: 22px; font-weight: 700; color:
#0f172a;">Daftar Produk Toko</h2>
<p style="margin: 4px 0 0 0; font-size: 14px; color: #64748b;">
Kelola seluruh barang dagangan yang tampil di halaman depan
toko Anda ({{ $products->count() }} Produk Aktif).
</p>

---

## Halaman 13

</div>

<a href="/admin/products/create" style="background-color: #0B5ED7;
color: #ffffff; text-decoration: none; padding: 11px 20px; border-radius:
8px; font-size: 14px; font-weight: 600;">
+ Tambah Produk Baru
</a>
</div>

<!-- 3. TABEL KATALOG PRODUK SELLER CENTER -->
<div style="background-color: #ffffff; border-radius: 12px; border: 1px
solid #e2e8f0; overflow: hidden;">
<table style="width: 100%; border-collapse: collapse; font-size:
14px;">
<thead>
<tr style="background-color: #f8fafc; color: #475569; textalign: left; border-bottom: 1px solid #e2e8f0;">
<th style="padding: 14px 20px; font-weight: 600; width:
90px;">Foto</th>
<th style="padding: 14px 20px; font-weight: 600;">Info
Produk</th>
<th style="padding: 14px 20px; font-weight: 600;">Harga
Satuan</th>
<th style="padding: 14px 20px; font-weight:
600;">Tanggal Ditambahkan</th>
<th style="padding: 14px 20px; font-weight: 600; textalign: right;">Pratinjau</th>
</tr>
</thead>
<tbody>
@forelse($products as $product)
<tr style="border-bottom: 1px solid #f1f5f9;">

<!-- Kolom 1: Thumbnail Foto Produk -->
<td style="padding: 16px 20px; vertical-align:
middle;">
@if($product->image)
<img src="{{ asset('assets/images/' .
$product->image) }}" style="width: 64px; height: 64px; object-fit: cover;
border-radius: 8px; border: 1px solid #e2e8f0; display: block;">
@else
<div style="width: 64px; height: 64px;
background-color: #f1f5f9; border-radius: 8px; display: flex; align-items:
center; justify-content: center; font-size: 11px; color: #94a3b8; textalign: center;">
No Img
</div>
@endif
</td>

---

## Halaman 14

<!-- Kolom 2: Nama & Cuplikan Spesifikasi -->
<td style="padding: 16px 20px; vertical-align:
middle;">
<div style="font-weight: 700; color: #0f172a;
font-size: 15px; margin-bottom: 4px;">
{{ $product->name }}
</div>
<div style="font-size: 13px; color: #64748b;
max-width: 420px; line-height: 1.5;">
{{ \Illuminate\Support\Str::limit($product-
>description, 90) }}
</div>
</td>

<!-- Kolom 3: Harga Produk -->
<td style="padding: 16px 20px; vertical-align:
middle; font-weight: 700; color: #0f172a; font-size: 15px;">
Rp {{ number_format($product->price, 0, ',',
'.') }}
</td>

<!-- Kolom 4: Waktu Input -->
<td style="padding: 16px 20px; vertical-align:
middle; color: #64748b; font-size: 13px;">
{{ $product->created_at ? $product->created_at-
>format('d M Y, H:i') : '-' }}
</td>

<!-- Kolom 5: Tautan Cek Halaman Detail -->
<td style="padding: 16px 20px; vertical-align:
middle; text-align: right;">
<a href="/detail/{{ $product->id }}"
target="_blank" style="color: #0B5ED7; text-decoration: none; font-weight:
600; font-size: 13px; background-color: #eff6ff; padding: 7px 12px; borderradius: 6px; border: 1px solid #bfdbfe;">
Lihat di Toko &nearr;
</a>
</td>

</tr>
@empty
<tr>
<td colspan="5" style="text-align: center; padding:
48px 20px; color: #64748b;">
Belum ada produk di etalase. Klik tombol
<strong>+ Tambah Produk Baru</strong> untuk mulai mengunggah barang.
</td>
</tr>

---

## Halaman 15

@endforelse
</tbody>
</table>
</div>

@endsection

LANGKAH 5: Membangun Formulir Upload Produk
(admin/create_product.blade.php) - Oleh Frontend
Sekarang kita rakit formulir tambah produk yang dilengkapi fitur Live Image Preview
(ketika Admin memilih foto dari komputer, pratinjau fotonya langsung tampil di layar
sebelum disimpan, persis seperti di Shopee/Tokopedia!).
1. Masih di dalam folder resources/views/admin/, klik kanan lalu pilih New File, dan
beri nama: create_product.blade.php.
2. Ketik kode lengkap berikut dengan teliti:
@extends('layouts.admin')
@section('konten_admin')

<!-- 1. BREADCRUMB SELLER CENTER -->
<div style="margin-bottom: 20px; font-size: 13px; color: #64748b; fontweight: 500;">
<a href="/admin/products" style="color: #0B5ED7; text-decoration:
none;">Katalog Produk</a>
<span style="margin: 0 8px;">/</span>
<span style="color: #0f172a; font-weight: 600;">Tambah Produk
Baru</span>
</div>

<!-- 2. PESAN PERINGATAN JIKA VALIDASI GAGAL (Misal file bukan gambar
atau > 2MB) -->
@if($errors->any())
<div style="background-color: #fef2f2; color: #991b1b; padding:
16px 20px; border-radius: 10px; border: 1px solid #fecaca; margin-bottom:
24px; font-size: 14px;">
<strong style="display: block; margin-bottom: 6px;">Gagal
menyimpan produk, periksa kembali isian berikut:</strong>
<ul style="margin: 0; padding-left: 20px;">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>

---

## Halaman 16

@endif

<!-- 3. KARTU FORMULIR TAMBAH PRODUK -->
<div style="background-color: #ffffff; border-radius: 12px; border: 1px
solid #e2e8f0; padding: 32px;">
<div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;
margin-bottom: 28px;">
<h2 style="margin: 0; font-size: 20px; font-weight: 700; color:
#0f172a;">Informasi & Media Produk</h2>
<p style="margin: 4px 0 0 0; font-size: 13px; color: #64748b;">
Pastikan foto produk memiliki pencahayaan yang baik dan
spesifikasi ditulis secara jelas.
</p>
</div>

<!-- WAJIB: Gunakan method="POST" dan enctype="multipart/form-data"
untuk Upload File -->
<form action="/admin/products/store" method="POST"
enctype="multipart/form-data">
@csrf

<div style="display: flex; gap: 36px; align-items: flexstart;">

<!-- KOLOM KIRI (35%): AREA UPLOAD FOTO & PREVIEW -->
<div style="width: 35%;">
<label style="font-weight: 600; font-size: 14px; color:
#0f172a; display: block; margin-bottom: 6px;">
Foto Produk Utama <span style="color:
#ef4444;">*</span>
</label>
<p style="font-size: 12px; color: #64748b; margin-top:
0; margin-bottom: 12px; line-height: 1.5;">
Format yang didukung: <strong>JPG, JPEG, PNG,
WEBP</strong>. Ukuran maksimal <strong>2 MB</strong>.
</p>

<!-- Kotak Pratinjau Gambar -->
<div style="border: 2px dashed #cbd5e1; border-radius:
10px; padding: 20px; text-align: center; background-color: #f8fafc; marginbottom: 12px;">
<img id="previewImage" src="" style="display: none;
width: 100%; height: 220px; object-fit: cover; border-radius: 8px; marginbottom: 12px; border: 1px solid #e2e8f0;">

<div id="placeholderText" style="padding: 40px
10px; color: #64748b; font-size: 13px;">
Belum ada foto dipilih.<br>Klik tombol di bawah
untuk mengunggah foto produk.

---

## Halaman 17

</div>

<input type="file" name="image" id="imageInput"
accept="image/png, image/jpeg, image/jpg, image/webp" required
onchange="previewFile(this)" style="width: 100%; font-size: 13px; color:
#475569;">
</div>
</div>

<!-- KOLOM KANAN (65%): SPESIFIKASI TEKS & HARGA -->
<div style="width: 65%;">

<div style="margin-bottom: 20px;">
<label style="font-weight: 600; font-size: 14px;
color: #0f172a; display: block; margin-bottom: 8px;">
Nama Produk <span style="color:
#ef4444;">*</span>
</label>
<input type="text" name="name" value="{{
old('name') }}" placeholder="Contoh: Sepatu Running Ortuseight Hyperblast
2.0" required style="width: 100%; padding: 12px 14px; border: 1px solid
#cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
</div>

<div style="margin-bottom: 20px;">
<label style="font-weight: 600; font-size: 14px;
color: #0f172a; display: block; margin-bottom: 8px;">
Harga Satuan (Rupiah) <span style="color:
#ef4444;">*</span>
</label>
<div style="display: flex; align-items: center;
border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden;
background-color: #f8fafc;">
<span style="padding: 12px 16px; font-weight:
700; color: #475569; font-size: 14px; border-right: 1px solid
#cbd5e1;">Rp</span>
<input type="number" name="price" value="{{
old('price') }}" min="100" placeholder="Contoh: 550000 (Ketik angka tanpa
titik)" required style="width: 100%; padding: 12px 14px; border: none;
font-size: 14px; font-family: inherit; outline: none; background:
#ffffff;">
</div>
</div>

<div style="margin-bottom: 28px;">
<label style="font-weight: 600; font-size: 14px;
color: #0f172a; display: block; margin-bottom: 8px;">
Deskripsi & Spesifikasi Lengkap <span
style="color: #ef4444;">*</span>

---

## Halaman 18

</label>
<textarea name="description" rows="6"
placeholder="Tuliskan spesifikasi lengkap, ukuran, garansi, dan keunggulan
produk..." required style="width: 100%; padding: 12px 14px; border: 1px
solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;
line-height: 1.6;">{{ old('description') }}</textarea>
</div>

<!-- Tombol Batal & Simpan -->
<div style="display: flex; justify-content: flex-end;
gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
<a href="/admin/products" style="padding: 12px
24px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569; textdecoration: none; font-size: 14px; font-weight: 600;">
Batal
</a>
<button type="submit" style="padding: 12px 28px;
border-radius: 8px; border: none; background-color: #0B5ED7; color:
#ffffff; font-size: 14px; font-weight: 600; font-family: inherit; cursor:
pointer;">
Simpan & Tampilkan Produk
</button>
</div>

</div>

</div>
</form>
</div>

<!-- Script Ringan untuk Menampilkan Pratinjau Foto Sebelum Di-upload -
->
<script>
function previewFile(input) {
var file = input.files[0];
if (file) {
var reader = new FileReader();
reader.onload = function(e) {
var img = document.getElementById('previewImage');
var txt = document.getElementById('placeholderText');
img.src = e.target.result;
img.style.display = 'block';
txt.style.display = 'none';
}
reader.readAsDataURL(file);
}
}
</script>

---

## Halaman 19

@endsection

LANGKAH 6: Mempercantik Tipografi Halaman Pembeli
(layouts/master.blade.php) - Oleh Frontend
Agar halaman depan toko (master.blade.php) memiliki kualitas font dan kehalusan
tampilan yang setara dengan halaman Seller Center barusan, mari kita pasang font Plus
Jakarta Sans di layouts/master.blade.php.
1. Buka file resources/views/layouts/master.blade.php.
2. Tambahkan pemanggilan Google Fonts Plus Jakarta Sans di dalam <head> dan
ubah font-family pada <body> seperti berikut:
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>E-Commerce Kelas XII</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;5
00;600;700&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 0;
background-color: #f8fafc; color: #0f172a;">

E. ULANGI & RAYAKAN (PENGUJIAN QUALITY ASSURANCE)
Project Manager, pimpin anggota tim kalian untuk menguji alur penambahan produk dari
Seller Center hingga tayang di halaman depan pembeli!
1. Pastikan php artisan serve menyala, lalu buka
http://localhost:8000/admin/products di Google Chrome.
2. Uji Tampilan & Tipografi Seller Center: Perhatikan kehalusan huruf Plus Jakarta
Sans dan tabel produk kalian. Pastikan ke-6 produk lama kalian tampil rapi di dalam
daftar tersebut.
3. Uji Tambah Produk & Pratinjau Foto:
o Klik tombol biru "+ Tambah Produk Baru" di pojok kanan atas (atau menu
+ Tambah Produk di navigasi atas).

---

## Halaman 20

o Pilih 1 file foto produk baru dari komputer kalian. Pastikan gambarnya
langsung muncul di kotak pratinjau sebelah kiri!
o Isi Nama Produk, Harga Satuan, dan Deskripsi multi-baris, lalu klik "Simpan
& Tampilkan Produk".
4. Uji Keberhasilan Penyimpanan Fisik & Database:
o Pastikan kalian diarahkan kembali ke /admin/products dengan kotak
notifikasi hijau di atas layar, dan jumlah produk bertambah menjadi 7 Produk
Aktif.
o Cek folder public/assets/images/ di panel kiri VS Code. Pastikan ada file
foto baru dengan awalan angka waktu (misal: 1756123456_produk.jpg).
5. Uji Sinkronisasi Etalase Pembeli & Checkout:
o Klik tombol "Lihat di Toko ↗" pada produk yang baru saja kalian unggah.
o Pastikan halaman Detail Produk (/detail/7) terbuka lengkap dengan gambar
yang baru diunggah, dan produk tersebut juga langsung muncul di beranda
utama (http://localhost:8000)!

F. PRAKTIK MANDIRI KELOMPOK (EKSPERIMEN VALIDASI &
PENGAYAAN KATALOG)
Lakukan eksperimen pengujian keamanan server dan lengkapi katalog toko kelompok kalian:
1. Uji Ketahanan Validasi File ($request->validate): Buka halaman
/admin/products/create. Coba pilih sebuah file bukan gambar (misalnya file
dokumen .docx, .pdf, atau .txt dengan mengubah pilihan All Files saat Browse file)
lalu klik Simpan. Perhatikan bagaimana validasi server Laravel menolak file
berbahaya tersebut dan menampilkan pesan peringatan merah tanpa merusak aplikasi!
2. Ekspansi Katalog Menjadi Minimal 9 Produk Asli: Gunakan formulir
/admin/products/create untuk mengunggah minimal 3 produk baru lengkap
dengan foto produk berkualitas tinggi sesuai tema toko kelompok kalian (hingga total
produk aktif di toko kalian berjumlah minimal 9 Produk).
3. Finalisasi LKPD: Project Manager memeriksa seluruh hasil pengujian dan memandu
pengisian LKPD Pertemuan 9 di bawah ini.

G. KESIMPULAN & MATERI SELANJUTNYA

---

## Halaman 21

Luar Biasa! Hari ini kalian telah berhasil memerdekakan aplikasi e-commerce kalian dari
ketergantungan pada ProductSeeder.php. Pemilik toko kini memiliki Seller Center
berdesain modern yang sanggup menerima unggahan foto produk langsung dari browser,
memvalidasi keamanannya, menyimpannya ke dalam direktori public/assets/images/,
dan menayangkannya secara instan ke etalase pembeli!
Persiapan Selanjutnya (Pertemuan 10): Kita sudah bisa Menampilkan produk (Read) dan
Menambah produk baru (Create). Namun, bagaimana jika harga barang naik, deskripsi salah
ketik, atau ada barang yang sudah berhenti diproduksi? Pada Pertemuan 10, kita akan
menuntaskan siklus CRUD Katalog Admin dengan membangun fitur Edit Produk (Update
Data & Ganti Foto) serta Hapus Produk (Delete Data & Hapus File Fisik)!

H. LEMBAR KERJA PESERTA DIDIK (LKPD) - PERTEMUAN 9
INSTRUMEN PENGUJIAN SELLER CENTER, UPLOAD GAMBAR
(multipart/form-data), & VALIDASI SERVER
A. IDENTITAS PROYEK KELOMPOK
 Nama Merek / Toko : .........................................................................
 Sektor E-Commerce : .........................................................................
 Pembagian Peran Pengujian :
1. Project Manager (QC Lead) : .........................................................................
2. UI/UX Designer (Frontend) : .........................................................................
3. Backend Developer (DB) : .........................................................................
B. CHECKLIST KONFIGURASI UPLOAD & SELLER CENTER UI (Wajib dicentang
oleh Project Manager setelah melihat langsung pekerjaan tim)
No Instruksi Kerja Fungsional (SOP) Status TTD
PM
1 Typography & Seller Center UI: Layout Admin & Toko telah
menerapkan font Plus Jakarta Sans dan navigasi Seller Center.
[ ] ...............
2 Multipart Form Setup: Tag <form> di
create_product.blade.php telah menggunakan
[ ] ...............

---

## Halaman 22

method="POST", @csrf, dan enctype="multipart/formdata".
3 Validation & File Move: Fungsi storeProduct() di
AdminController telah memvalidasi tipe file dan memindahkan
foto ke public/assets/images/.
[ ] ...............
4 Ekspansi Katalog: Kelompok berhasil mengunggah minimal 3
produk baru via form web (Total katalog $\ge$ 9 produk).
[ ] ...............
C. MATRIKS PENGUJIAN FUNGSIONAL & VALIDASI FILE (QUALITY
ASSURANCE) (Eksekusi di peramban Google Chrome dan tandai status kelulusannya)
Skenario Pengujian Sistem
Terpadu
Target yang Diharapkan (Expected
Result)
Status
Kelulusan
Uji Live Preview & Upload
Foto Produk
Saat memilih foto di form tambah produk,
pratinjau muncul dan setelah disimpan foto
tampil di tabel /admin/products.
[ ] PASS [
] FAIL
Uji Penyimpanan Fisik
(public/assets/images)
File gambar yang diunggah benar-benar
tersimpan di folder
public/assets/images/ dengan awalan
angka waktu (time()).
[ ] PASS [
] FAIL
Uji Proteksi Validasi Server
(validate)
Mengunggah file selain gambar (misal
.pdf / .docx) atau ukuran > 2MB berhasil
ditolak oleh server dengan pesan
peringatan.
[ ] PASS [
] FAIL
Uji Sinkronisasi Etalase
Depan (/)
Produk baru yang diinput dari Seller
Center otomatis tampil di beranda Katalog
pembeli dan dapat dibeli hingga Checkout.
[ ] PASS [
] FAIL

---

## Halaman 23

D. DOKUMENTASI VALIDASI TANGKAPAN LAYAR (SCREENSHOT)
1. Bukti Halaman Formulir Tambah Produk & Live Preview
(/admin/products/create)(Tempel di sini - Pastikan gambar pratinjau produk dan isian
spesifikasi terlihat jelas)
2. Bukti Halaman Daftar Katalog Produk Seller Center (/admin/products)(Tempel di
sini - Pastikan notifikasi sukses dan daftar produk baru beserta thumbnail fotonya terlihat
rapi)
3. Bukti Kemunculan Produk Baru di Halaman Katalog Pembeli
(http://localhost:8000)(Tempel di sini - Tampilkan halaman beranda toko yang sudah
memuat tambahan produk baru)
E. JURNAL PEMECAHAN MASALAH ANALITIS (TROUBLESHOOTING)
Studi Kasus Arsitektur Upload Berkas:
1. Pada create_product.blade.php, kita wajib menambahkan atribut
enctype="multipart/form-data" pada tag <form>, dan di AdminController.php
kita menambahkan angka time() di depan nama file foto (time() . '_' . $file-
>getClientOriginalName()). Jelaskan dua hal berikut:
o Apa yang akan terjadi jika programmer lupa menuliskan atribut
enctype="multipart/form-data" pada form upload foto?
o Mengapa kita harus menempelkan angka time() di depan nama file gambar
sebelum disimpan ke folder public/assets/images?
Jawab:
......................................................................................................................................................
...
Mengetahui / Mengesahkan,
Guru Mata Pelajaran Pemrograman Web,

( Sulthan Alawy Shihab, S.Kom )
