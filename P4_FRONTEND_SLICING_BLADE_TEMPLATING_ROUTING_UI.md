# PERTEMUAN 4
## FRONTEND SLICING, BLADE TEMPLATING, & ROUTING UI

**Guru Pengampu**: Sulthan Alawy Shihab, S.Kom
**Alokasi Waktu**: 8 JP x 45 Menit
**Materi Pokok**: Translasi Figma, Box Model, Laragon Setup, UI Routing
**Model Belajar**: Quantum Learning (TANDUR)
**Proyek Utama**: E-Commerce (Slicing 4 Halaman Utama Terintegrasi)

---

## A. TUJUAN PEMBELAJARAN

Setelah mengikuti pembelajaran ini, peserta didik diharapkan mampu:

1. **Memahami (C2)** mekanisme *Frontend Slicing* sebagai proses menerjemahkan rancangan visual (Figma) menjadi struktur kode (HTML/CSS) berstandar industri.
2. **Menganalisis (C4)** metrik visual pada antarmuka prototipe (kode HEX warna, *padding*, ukuran elemen) untuk memecah tata letak ke dalam *Master Layout*.
3. **Mendemonstrasikan (P3)** pembacaan *properties* di Figma, instalasi lingkungan pengembangan (Laragon), dan integrasi aset visual ke folder publik Laravel.
4. **Membangun (C6)** cangkang antarmuka (*Front-End*) 4 halaman utama aplikasi e-commerce (Katalog, Detail, Checkout, Berhasil) yang responsif dan saling terhubung melalui sistem *Routing*.

---

## B. TUMBUHKAN (ENROLL) & PEMAHAMAN KONSEP

> **"Menerjemahkan Imajinasi Menjadi Realitas Digital"**

Pada pertemuan sebelumnya, kalian telah sukses menjadi seorang *UI/UX Designer*. Prototipe interaktif kalian di Figma sudah sangat indah, memiliki identitas *brand* yang kuat, dan alur navigasi yang jelas.

Namun, di dunia industri rekayasa perangkat lunak, sehebat apa pun desain di Figma, ia hanyalah sebuah "gambar mati" yang tidak bisa dibaca oleh peramban web (*browser*). Hari ini, fase desain kita tutup dan kita kunci (*Design Sign-Off*). Desain tersebut kini berstatus sebagai **Cetak Biru (Blueprint) Mutlak**.

Kalian akan berganti peran menjadi seorang **Frontend Developer**. Tugas kalian hari ini sangat krusial: membedah gambar dari Figma tersebut, memindahkan warna dan ukurannya secara presisi, lalu membangun pondasinya menggunakan kerangka kerja Laravel di ekosistem Laragon. Siapkan ketelitian tingkat tinggi, karena *Software Engineer* yang baik tidak akan membiarkan perbedaan 1 piksel pun antara desain dan kode!

---

## C. ALAMI & NAMAI (LANDASAN TEORI FORMAL)

Sebagai calon *Software Engineer* profesional, kalian wajib menguasai konsep dan terminologi teknis sebelum menyentuh *Code Editor*.

### 1. Analisis Translasi: Frontend Slicing & Box Model

- **Definisi Formal:** *Frontend Slicing* adalah proses mengekstraksi elemen desain UI/UX untuk dibangun ulang menggunakan bahasa *Markup* (HTML) dan presentasi (CSS). Dalam proses ini, *programmer* menggunakan prinsip *Box Model*, di mana setiap elemen (gambar/teks) dianggap sebagai sebuah "kotak" yang memiliki batas (*border*), jarak dalam (*padding*), dan jarak luar (*margin*).
- **Analogi:** Bayangkan Figma adalah gambar denah rumah dari seorang Arsitek. *Slicing* adalah proses saat Tukang Bangunan menyusun batu bata (HTML) dan mengecat temboknya (CSS) agar wujud fisiknya identik dengan denah.

### 2. Infrastruktur Server Lokal: Laragon & Composer

- **Definisi Formal:** Aplikasi tingkat lanjut seperti Laravel tidak bisa dijalankan hanya dengan klik ganda *file* HTML. Komputer membutuhkan *Web Server*. **Laragon** adalah lingkungan pengembangan modern yang sangat ringan dan berkinerja tinggi. Sementara **Composer** adalah Manajer Paket (*Dependency Manager*) PHP yang bertugas mengunduh ribuan *file* sistem Laravel dari *server* pusat secara otomatis.

### 3. Pemisahan Logika MVC & Blade Templating

- **Definisi Formal:** Laravel menggunakan pola MVC (*Model-View-Controller*). Bagian layar antarmuka dikelola oleh *View* (berupa *file* `.blade.php`). Untuk menghindari penulisan ulang kode secara terus-menerus (Prinsip *DRY - Don't Repeat Yourself*), Laravel menyediakan **Blade Templating**.
- **Penerapan:** Kita hanya perlu membuat 1 bingkai utama (*Master Layout*) yang berisi Header dan Footer. Halaman lain (Katalog, Checkout) cukup menyewa bingkai tersebut dan mengisi area tengahnya saja.

### 4. Literasi Syntax (Kamus Perintah Mesin)

| KODE / PERINTAH | FUNGSI TEKNIS / FORMAL | ANALOGI (BAHASA MANUSIA) |
|---|---|---|
| `composer create-project...` | Menginstruksikan manajer paket untuk merakit ekosistem Laravel. | "Panggil kontraktor untuk membangun pondasi rumah berstandar industri." |
| `@extends('layouts.master')` | *Blade directive* untuk mewarisi struktur *file* induk. | "Pinjam bingkai lukisan (Header & Footer) yang sudah ada, saya cuma mau melukis tengahnya." |
| `@yield('konten_utama')` | Menciptakan area dinamis yang bisa diisi oleh halaman lain. | "Siapkan ruang kosong di tengah bingkai ini untuk diisi lukisan baru nantinya." |
| `Route::get('/...', ...)` | Menentukan jalur URL akses publik via *file* `web.php`. | "Pasang papan penunjuk jalan. Kalau ada pengunjung datang ke alamat ini, arahkan ke ruangan itu." |

---

## D. DEMONSTRASIKAN (PRAKTIKUM STEP-BY-STEP)

Mari kita bangun arsitektur **4 Halaman Utama** sekaligus: **Katalog -> Detail -> Checkout -> Transaksi Berhasil**. Ikuti panduan ini dengan saksama.

### TAHAP 1: Membaca Figma Seperti Programmer (Translasi Visual)

Sebelum menulis kode, seorang *Programmer* harus tahu dari mana mengambil ukuran dan warna pada desain yang sudah dikerjakan di Figma.

1. **Cara Mengambil Warna (CSS Background & Color):**
   - Buka *file* Figma kelompok kalian. Klik pada sebuah tombol (misal tombol "Beli").
   - Lihat panel sebelah **Kanan**. Cari bagian **Fill**. Di sana akan tercantum kode HEX warna, contohnya `#0B5ED7`. Salin kode ini untuk digunakan di VS Code.
2. **Cara Mengetahui Ukuran (Width & Height):**
   - Klik elemen kotak produk di Figma. Lihat panel **Kanan Atas**.
   - Terdapat huruf **W** (Width/Lebar) dan **H** (Height/Tinggi). Jika W tertulis `250`, maka pada kode CSS nanti kalian wajib mengetik `width: 250px;`.
3. **Cara Mengekspor Gambar (Assets):**
   - Klik elemen Logo Toko atau Foto Produk di Figma.
   - Lihat panel **Kanan**, gulir ke paling bawah, tekan ikon tanda tambah **(+)** di sebelah tulisan **Export**.
   - Pilih format **PNG**, lalu tekan tombol *Export*. Simpan *file* tersebut di laptop kalian.

---

### TAHAP 2: Instalasi Laragon & Pembuatan Master Layout

Sekarang kita siapkan server dan membuat "Bingkai Utama" agar *Header* dan *Footer* tidak perlu diketik berulang kali.

1. Buka aplikasi **Laragon**, pastikan Apache & MySQL menyala (*Start All*).
2. Buka **Terminal** bawaan Laragon, ketik perintah ini lalu tekan `Enter`:

```
composer create-project laravel/laravel ecomm-kelompok
```

3. Buka **Visual Studio Code (VS Code)**, klik **File > Open Folder**, arahkan ke `C:\laragon\www\ecomm-kelompok`. Atau di terminal ketik perintah: `code .`

4. Di panel kiri, masuk ke `resources/views/`. Buat folder baru bernama `layouts`.
5. Di dalam folder `layouts`, buat *file* baru: `master.blade.php`.
6. Ketik kode ini dan literasi ulang jangan asal copas saja, perhatikan jika ada instruksi untuk mengganti warna atau ukuran:

**`resources/views/layouts/master.blade.php`**

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce Kelas XII</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f9;">

    <!-- 1. HEADER (Bingkai Atas) -->
    <!-- Ganti #1a1a1a dengan kode HEX dari Figma kalian -->
    <header style="background-color: #1a1a1a; color: white; padding: 15px 50px; display: flex; justify-content: space-between;">
        <h2 style="margin: 0;">🛒 Techzone</h2>
        <nav style="margin-top: 5px;">
            <a href="/" style="color: white; text-decoration: none; margin-left: 20px;">Katalog</a>
        </nav>
    </header>

    <!-- 2. MAIN (Area Konten Dinamis) -->
    <main style="padding: 40px 50px; min-height: 70vh;">
        <!-- Lubang cerdas ini akan diisi oleh halaman Katalog/Checkout -->
        @yield('konten_utama')
    </main>

    <!-- 3. FOOTER (Bingkai Bawah) -->
    <footer style="background-color: #ddd; padding: 20px; text-align: center;">
        <p style="margin: 0;">&copy; 2026 Hak Cipta Dilindungi - SMK Plus Pelita Nusantara</p>
    </footer>

</body>
</html>
```

---

### TAHAP 3: Membangun Halaman Katalog & Detail Produk

Mari kita lukis isi halamannya dengan memanggil bingkai utama di atas.

1. Masih di `resources/views/` (Di luar folder `layouts`), buat *file* `katalog.blade.php`.
2. Ketik kode ini dan literasi ulang jangan asal copas saja, perhatikan jika ada instruksi untuk mengganti warna atau ukuran:

**`resources/views/katalog.blade.php`**

```html
@extends('layouts.master')

@section('konten_utama')
    <h2 style="color: #333; margin-bottom: 20px;">Katalog Produk</h2>

    <!-- KOTAK PRODUK -->
    <!-- Ganti width: 250px sesuai ukuran W (Width) di Figma kalian -->
    <div style="background-color: white; border: 1px solid #ccc; width: 250px; padding: 15px; border-radius: 8px;">
        <div style="background-color: #eee; height: 150px; text-align: center; line-height: 150px; border-radius: 4px;">
            [Foto Produk]
        </div>
        <h3 style="margin-top: 15px;">Nama Sepatu/Baju</h3>
        <p style="color: #E63946; font-weight: bold; font-size: 18px;">Rp 150.000</p>

        <!-- Pintu menuju halaman Detail -->
        <a href="/detail" style="display: block; text-align: center; background-color: #0B5ED7; color: white; padding: 10px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Lihat Detail
        </a>
    </div>
@endsection
```

3. Buat *file* baru: `detail.blade.php`.
4. Ketik kode ini dan literasi ulang jangan asal copas saja, perhatikan jika ada instruksi untuk mengganti warna atau ukuran:

**`resources/views/detail.blade.php`**

```html
@extends('layouts.master')

@section('konten_utama')
    <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: bold;">&larr; Kembali ke Katalog</a>

    <div style="display: flex; margin-top: 20px; background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #ccc;">
        <!-- Gambar Kiri -->
        <div style="width: 40%; background-color: #eee; height: 300px; text-align: center; line-height: 300px; border-radius: 8px;">
            [Foto Produk Besar]
        </div>

        <!-- Spesifikasi Kanan -->
        <div style="width: 60%; padding-left: 30px;">
            <h2>Nama Sepatu/Baju</h2>
            <h3 style="color: #E63946;">Rp 150.000</h3>
            <p><strong>Spesifikasi:</strong></p>
            <ul>
                <li>Bahan: Material Premium</li>
                <li>Ukuran tersedia: Sesuaikan produk kalian</li>
                <li>Kondisi: Baru 100%</li>
            </ul>
            <p>Deskripsi: Tuliskan rincian produk yang membuat pembeli tertarik di sini.</p>

            <!-- Pintu menuju halaman Checkout -->
            <a href="/checkout" style="display: inline-block; background-color: #28A745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px;">
                Beli Sekarang
            </a>
        </div>
    </div>
@endsection
```

---

### TAHAP 4: Membangun Halaman Checkout & Berhasil

1. Buat *file* baru: `checkout.blade.php`.
2. Ketik kode ini dan literasi ulang jangan asal copas saja, perhatikan jika ada instruksi untuk mengganti warna atau ukuran:

**`resources/views/checkout.blade.php`**

```html
@extends('layouts.master')

@section('konten_utama')
    <h2 style="margin-bottom: 20px;">Pengiriman & Pembayaran</h2>

    <div style="background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #ccc; width: 60%;">
        <!-- Pintu menuju halaman Berhasil setelah tombol diklik -->
        <form action="/berhasil" method="GET">
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Nama Lengkap:</label><br>
                <input type="text" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Alamat Pengiriman:</label><br>
                <textarea style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;" rows="3" required></textarea>
            </div>

            <hr style="margin: 20px 0;">
            <h3 style="text-align: right;">Total Bayar: <span style="color: #E63946;">Rp 150.000</span></h3>

            <!-- Tombol Konfirmasi -->
            <button type="submit" style="background-color: #FFC107; color: black; padding: 15px; width: 100%; border: none; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">
                Konfirmasi Pesanan
            </button>
        </form>
    </div>
@endsection
```

3. Buat *file* penutup: `berhasil.blade.php`.
4. Ketik kode ini dan literasi ulang jangan asal copas saja, perhatikan jika ada instruksi untuk mengganti warna atau ukuran:

**`resources/views/berhasil.blade.php`**

```html
@extends('layouts.master')

@section('konten_utama')
    <div style="text-align: center; background-color: white; padding: 50px; border-radius: 8px; border: 1px solid #ccc; width: 50%; margin: 0 auto;">
        <h1 style="font-size: 60px; margin: 0;">🎉</h1>
        <h2 style="color: #28A745; margin-top: 10px;">Transaksi Berhasil!</h2>
        <p style="color: #666;">Terima kasih, pesanan Anda sedang kami proses.</p>
        <p>Nomor Resi: <strong style="color: #333;">INV-2026-XYZ99</strong></p>

        <br>
        <a href="/" style="display: inline-block; background-color: #0B5ED7; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px;">
            Kembali ke Beranda
        </a>
    </div>
@endsection
```

---

### TAHAP 5: Mendaftarkan Alamat URL (Routing)

*File* antarmuka sudah sangat rapi, tetapi peramban (*browser*) belum tahu arah jalannya. Kita harus memperbarui buku rute.

1. Buka folder `routes/` lalu klik *file* `web.php`.
2. Hapus isi *file* tersebut, lalu ketik kode pemetaan jalan ini:

**`routes/web.php`**

```php
<?php
use Illuminate\Support\Facades\Route;

// Jalur 1: Halaman Katalog (Awal)
Route::get('/', function () {
    return view('katalog');
});

// Jalur 2: Halaman Detail Produk
Route::get('/detail', function () {
    return view('detail');
});

// Jalur 3: Halaman Checkout
Route::get('/checkout', function () {
    return view('checkout');
});

// Jalur 4: Halaman Transaksi Berhasil
Route::get('/berhasil', function () {
    return view('berhasil');
});
```

---

## E. ULANGI & RAYAKAN (PENGUJIAN QUALITY ASSURANCE)

Dalam dunia *Software Engineering*, kita tidak boleh langsung puas sebelum melihat hasilnya merespons dengan benar di layar *browser*.

1. Buka Terminal VS Code ketik perintah:

```
php artisan serve
```

2. Buka Google Chrome, ketik alamat: `http://localhost:8000`

3. **Validasi Alur UX (User Experience):**
   - Saat halaman terbuka, apakah **Katalog** muncul sempurna?
   - Klik tombol "Lihat Detail". Apakah berpindah ke halaman **Detail Produk**?
   - Klik tombol "Beli Sekarang". Apakah masuk ke form **Checkout**?
   - Isi nama dan alamat, lalu klik "Konfirmasi". Apakah sukses masuk ke halaman **Transaksi Berhasil**?

Jika keempat halaman tersebut bisa saling terhubung dari awal sampai akhir tanpa menemui pesan *Error 404*, maka arsitektur UI dan *Routing* kalian dinyatakan **LULUS (PASS)**!

---

## F. PRAKTIK MANDIRI KELOMPOK (SINKRONISASI VISUAL)

Kerangka (tulang) web dari 4 halaman utama kalian sudah jadi dan saling terhubung. Di sisa waktu praktikum ini, tugas kalian adalah menghidupkan warnanya agar **100% sama dengan Figma kelompok kalian**!

**SOP Eksekusi Tim:**

1. **UI/UX Designer:** Ingat kembali "Tahap 1". Ekspor logo toko dan gambar produk dari Figma (format `.png`), lalu bacakan kode warna HEX kepada sang *Coder*.
2. **Backend / Coder:** Buat folder `public/assets/images/` di dalam VS Code, lalu masukkan gambar yang diekspor tadi ke dalamnya.
3. **Integrasi Gambar:** Buka *file-file* `.blade.php` tadi. Ganti tulisan `[Foto Produk]` dengan memanggil fungsi tangan robot Laravel:

```html
<img src="{{ asset('assets/images/namafoto.png') }}" style="width: 100%; border-radius: 4px;">
```

4. **Sentuhan Akhir:** Ganti kode warna `background-color` yang ada di kode demonstrasi tadi dengan kode warna yang dibacakan oleh tim *UI/UX Designer* kalian!

---

## G. KESIMPULAN & MATERI SELANJUTNYA

Hari ini kalian telah membuktikan kelas kalian! Kalian tidak lagi mengetik HTML satu per satu secara kaku, melainkan membedahnya dari Figma secara presisi, lalu menyusunnya menggunakan arsitektur *Master Layout* untuk menjaga konsistensi tampilan dari Katalog hingga Checkout.

Namun, aplikasi e-commerce kita saat ini masih bersifat "Statis" (datanya diketik manual langsung di HTML). Pada pertemuan berikutnya, kita akan membangun **Gudang Data (Database & Migration)** agar admin dapat menginput ratusan barang dari belakang layar, dan halaman Katalog kalian akan menampilkan produk tersebut secara otomatis dan dinamis!
