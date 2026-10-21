# SMK PLUS PELITA NUSANTARA BOGOR

**KOMPETENSI KEAHLIAN REKAYASA PERANGKAT LUNAK**

Jl. Golf Ciriung-Cibinong Tlp/Fax. (021) 83713168
Website: http://www.smkpluspnb.sch.id | e-mail: rplsmkpenus@gmail.com

---

## PERTEMUAN 7

### TRANSAKSI CHECKOUT, KEAMANAN CSRF, & ELOQUENT INSERT DATA

- **Guru Pengampu** : Sulthan Alawy Shihab, S.Kom
- **Alokasi Waktu** : 8 JP x 45 Menit
- **Materi Pokok** : HTTP POST, CSRF Token, Migration Tabel Transactions, Eloquent `create()`, Dynamic Invoice
- **Model Belajar** : Quantum Learning (TANDUR)
- **Proyek Utama** : E-Commerce (Merekam Pesanan Pembeli ke Database & Mencetak Invoice)

---

## A. TUJUAN PEMBELAJARAN

Setelah mengikuti praktikum ini, peserta didik diharapkan mampu:

1. Memahami (C2) perbedaan arsitektur jalur HTTP `GET` (menampilkan halaman) dan `POST` (mengirimkan paket data rahasia ke server).
2. Menganalisis (C4) mekanisme keamanan formulir web menggunakan token `@csrf` (*Cross-Site Request Forgery*) untuk menangkal serangan manipulasi data.
3. Mendemonstrasikan (P3) pembuatan skema tabel `transactions` melalui *Migration* serta menangkap input pengguna menggunakan *Object* `Request` pada *Controller*.
4. Membangun (C6) alur transaksi *Checkout* utuh yang mampu menghitung total biaya (Harga Produk + Ongkos Kirim), menyimpan pesanan secara permanen ke MySQL (`Transaction::create()`), dan mencetak halaman *Invoice* dinamis.

---

## B. TUMBUHKAN (ENROLL) & ILUSTRASI PROJECT

### "Dari Etalase Pajangan Menjadi Mesin Pencetak Transaksi"

Pada Pertemuan 6, kalian telah berhasil menghidupkan halaman Detail Produk menggunakan *Route Model Binding*. Di bagian bawah halaman detail tersebut, kalian juga sudah menyiapkan tombol **"+ Masukkan Keranjang"** yang mengarah ke alamat `/checkout/{{ $product->id }}`.

Namun, coba kalian klik tombol hijau tersebut sekarang. Apa yang terjadi? Layar peramban akan menampilkan pesan **404 NOT FOUND**! Mengapa? Karena di file `web.php`, rute `/checkout` kalian masih statis (belum memiliki parameter `{id}`), dan formulir di `checkout.blade.php` masih menggunakan metode `GET` biasa yang hanya berpindah halaman tanpa menyimpan data apa pun.

Di dunia industri *e-commerce*, data pesanan pembeli adalah aset keuangan perusahaan. Hari ini, kita akan membangun tabel `transactions` di MySQL, menghidupkan halaman `/checkout/{id}`, mengamankan formulirnya dengan segel `@csrf`, dan memprogram *Controller* agar setiap kali tombol **"Konfirmasi Pesanan"** ditekan, data pembeli langsung terekam permanen di *database* beserta nomor *Invoice* resminya!

---

### ILUSTRASI HASIL AKHIR PROJECT HARI INI:

Alur sistem kalian hari ini akan bekerja secara berantai dari halaman Checkout hingga mencetak bukti transaksi dinamis:

#### LAYAR 1: FORM CHECKOUT (`localhost:8000/checkout/2`)

**[ BREADCRUMB ]** *Katalog Utama / Jaket Premium / Checkout*

**RINGKASAN BARANG DIPESAN:**

**Jaket Premium** — Harga Satuan: *Rp 200.000*

**FORMULIR PENGIRIMAN (Method: POST + @csrf):**

- **Nama Lengkap Penerima:** [ Sulthan Alawy Shihab ]
- **Nomor WhatsApp / HP:** [ 081234567890 ]
- **Alamat Lengkap:** [ Jl. Golf Ciriung, Cibinong, Bogor ]
- **Pilih Kurir Ekspedisi:** [ JNE Reguler - Rp 15.000 (v) ]
- **Jumlah Beli (Qty):** [ 1 ]

**[ TOMBOL: KONFIRMASI & BAYAR SEKARANG ]** *(Data disimpan ke MySQL)*

#### LAYAR 2: INVOICE DINAMIS (`localhost:8000/berhasil/1`)

**TRANSAKSI BERHASIL!**

*Terima kasih **Sulthan Alawy Shihab**, pesanan Anda telah tercatat di sistem kami.*

- **Nomor Resi / Invoice:** INV-2026-0001
- **Produk Dipesan:** Jaket Premium (1x)
- **Ekspedisi Pengiriman:** JNE Reguler (Tujuan: Jl. Golf Ciriung, Cibinong, Bogor)
- **Rincian Pembayaran:** Rp 200.000 + Ongkir Rp 15.000 = **Total Bayar: Rp 215.000**
- **Status Pesanan:** PENDING (Menunggu Diproses)

**[ TOMBOL: KEMBALI KE BERANDA ]**

---

## C. ALAMI & NAMAI (LANDASAN TEORI & PEMBAGIAN PERAN)

Sebelum menulis kode, pahami 3 konsep utama pemrosesan transaksi web berikut:

### 1. Perbedaan Rute `GET` vs `POST`

- **`Route::get()`**: Digunakan saat peramban *meminta* tampilan halaman dari server (contoh: membuka halaman katalog `/`, membuka detail `/detail/{id}`, atau membuka formulir `/checkout/{id}`).
- **`Route::post()`**: Digunakan khusus saat formulir HTML *mengirimkan* paket data sensitif (nama, alamat, nomor HP, total uang) di balik layar menuju *Controller* untuk disimpan ke database. Data `POST` tidak akan terlihat di bilah alamat URL.

### 2. Keamanan `@csrf` (Cross-Site Request Forgery Protection)

Laravel mewajibkan setiap tag `<form method="POST">` memiliki direktif `@csrf` di dalamnya. Tanpa `@csrf`, Laravel akan menolak pengiriman formulir dan memunculkan layar **Error 419 | PAGE EXPIRED**. Fitur ini mencegah pihak luar (peretas) mengirimkan pesanan palsu dari situs lain ke dalam database toko kita.

### 3. Literasi Syntax (Kamus Perintah Mesin)

| KODE PERINTAH | FUNGSI TEKNIS / FORMAL | ANALOGI (BAHASA MANUSIA) |
|---|---|---|
| `@csrf` | Mencetak *input* tersembunyi berisi *token* keamanan sesi pengguna. | "Tempelkan segel hologram resmi pada formulir agar satpam server tahu ini formulir asli." |
| `<input type="hidden" ...>` | Menyisipkan data (seperti `product_id`) ke dalam form tanpa ditampilkan di layar. | "Selipkan barcode barang di dalam amplop pesanan agar kasir tahu barang apa yang dibeli." |
| `Request $request` | Objek pada *Controller* untuk menangkap seluruh isi ketikan dari formulir HTML. | "Petugas penerima paket yang membuka amplop formulir dan membaca seluruh isian pembeli." |
| `Transaction::create([...])` | Menyimpan (*Insert*) satu baris data transaksi baru ke dalam tabel MySQL. | "Catat rincian pesanan pembeli ini secara permanen ke dalam buku besar kasir." |

### PEMBAGIAN TUGAS SPESIALISASI TIM:

- **BACKEND DEVELOPER (Fokus Basis Data & Logika Transaksi):**
  Membuat model dan *migration* tabel `transactions`, menambahkan rute dinamis `/checkout/{id}`, `/checkout/proses`, dan `/berhasil/{id}` di `web.php`, serta merakit logika perhitungan total harga dan penyimpanan data di `ProductController.php`.

- **UI/UX DESIGNER / FRONTEND (Fokus Formulir & Invoice Dinamis):**
  Merombak `checkout.blade.php` agar menampilkan ringkasan barang yang diklik dari P6, menambahkan `<form method="POST">`, menyematkan `@csrf`, menambahkan pilihan kurir sesuai rancangan P2/P3, serta memperbarui `berhasil.blade.php` agar mencetak *Invoice* asli dari database.

- **PROJECT MANAGER (Fokus Quality Assurance & Validasi Data):**
  Memastikan nama atribut `name="..."` pada input HTML yang diketik *Frontend* sama persis dengan nama variabel `$request->...` yang dipanggil *Backend*. PM wajib memverifikasi masuknya data di `phpMyAdmin` dan menguji ketahanan sistem terhadap *Error 419*.

---

## D. DEMONSTRASIKAN (PRAKTIKUM STEP-BY-STEP)

Pastikan Apache dan MySQL pada aplikasi Laragon sudah menyala hijau (*Start All*), lalu buka folder proyek kalian di Visual Studio Code.

### LANGKAH 1: Membangun Tabel `transactions` (Migration & Model) - Oleh Backend

Sesuai rancangan ERD di Pertemuan 2, kita membutuhkan tabel khusus untuk mencatat setiap pesanan yang masuk.

1. Buka Terminal di VS Code, ketik perintah berikut lalu tekan Enter:

   ```bash
   php artisan make:model Transaction -m
   ```

2. Buka folder `database/migrations/`, lalu klik file paling bawah yang berakhiran `_create_transactions_table.php`.
3. Ubah fungsi `up()` di dalamnya agar memiliki kolom penyimpanan transaksi yang lengkap:

   ```php
   public function up(): void
   {
       Schema::create('transactions', function (Blueprint $table) {
           $table->id();
           $table->string('invoice_code');        // Menyimpan Nomor Resi/Invoice (Contoh: INV-2026-001)
           $table->integer('product_id');         // Menyimpan ID Barang yang dibeli
           $table->string('product_name');        // Menyimpan Nama Barang saat dibeli
           $table->string('customer_name');       // Menyimpan Nama Lengkap Pembeli
           $table->string('customer_phone');      // Menyimpan Nomor HP/WA Pembeli
           $table->text('customer_address');      // Menyimpan Alamat Pengiriman
           $table->string('courier');             // Menyimpan Kurir (JNE / J&T / SiCepat)
           $table->integer('quantity');           // Menyimpan Jumlah Beli
           $table->integer('shipping_cost');      // Menyimpan Ongkos Kirim
           $table->integer('total_amount');       // Menyimpan Total Bayar (Harga x Qty + Ongkir)
           $table->string('status')->default('Pending'); // Status pesanan awal
           $table->timestamps();
       });
   }
   ```

4. Jalankan perintah migrasi di Terminal untuk membangun tabel fisik di MySQL:

   ```bash
   php artisan migrate
   ```

5. Buka file `app/Models/Transaction.php`. Buka gembok pengaman tabel dengan menambahkan `protected $guarded = [];` seperti saat kalian mengatur model `Product` di P5:

   ```php
   <?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class Product extends Model // Pastikan tertulis: class Transaction extends Model
   ```

   *(Ketik kode lengkap `app/Models/Transaction.php` seperti di bawah ini)*:

   ```php
   <?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class Transaction extends Model
   {
       // Mengizinkan seluruh kolom tabel transactions untuk diisi data
       protected $guarded = [];
   }
   ```

---

### LANGKAH 2: Mendaftarkan Rute Checkout & Proses POST (`web.php`) - Oleh Backend

Ingat, tombol di halaman detail P6 mengarah ke `/checkout/{{ $product->id }}`. Sekarang kita daftarkan jalur tersebut beserta jalur `POST` di `routes/web.php`.

1. Buka file `routes/web.php`.
2. Perbarui seluruh isi kode `routes/web.php` kalian menjadi seperti di bawah ini:

   ```php
   <?php

   use Illuminate\Support\Facades\Route;
   use App\Http\Controllers\ProductController;

   // 1. Jalur Beranda Katalog (Dari P5)
   Route::get('/', [ProductController::class, 'index']);

   // 2. Jalur Detail Produk Dinamis (Dari P6)
   Route::get('/detail/{id}', [ProductController::class, 'show']);

   // 3. Jalur Menampilkan Formulir Checkout sesuai ID Barang (MATERI P7)
   Route::get('/checkout/{id}', [ProductController::class, 'checkout']);

   // 4. Jalur Rahasia (POST) untuk Merekam Pesanan ke Database (MATERI P7)
   Route::post('/checkout/proses', [ProductController::class, 'storeTransaction']);

   // 5. Jalur Menampilkan Halaman Berhasil & Invoice Dinamis (MATERI P7)
   Route::get('/berhasil/{id}', [ProductController::class, 'success']);
   ```

---

### LANGKAH 3: Menambahkan Logika Checkout & Insert Data di Controller - Oleh Backend

Kita akan menambahkan 3 fungsi baru (`checkout`, `storeTransaction`, dan `success`) ke dalam `ProductController.php`.

1. Buka file `app/Http/Controllers/ProductController.php`.
2. Pastikan di bagian atas kalian memanggil `use App\Models\Transaction;`.
3. Perhatikan dan lengkapi kode `ProductController.php` kalian hingga persis seperti berikut:

   ```php
   <?php

   namespace App\Http\Controllers;

   use App\Models\Product;
   use App\Models\Transaction; // <-- [WAJIB] Panggil Model Transaction untuk menyimpan pesanan
   use Illuminate\Http\Request;

   class ProductController extends Controller
   {
       // FUNGSI 1: Menampilkan seluruh produk di Katalog (P5)
       public function index()
       {
           $products = Product::all();
           return view('katalog', compact('products'));
       }

       // FUNGSI 2: Menampilkan 1 produk spesifik di halaman Detail (P6)
       public function show($id)
       {
           $product = Product::findOrFail($id);
           return view('detail', compact('product'));
       }

       // FUNGSI 3: Menampilkan halaman Form Checkout dengan membawa data barang yang dipilih (P7)
       public function checkout($id)
       {
           $product = Product::findOrFail($id);
           return view('checkout', compact('product'));
       }

       // FUNGSI 4: Menangkap kiriman Form (POST), menghitung total, dan menyimpan ke MySQL (P7)
       public function storeTransaction(Request $request)
       {
           // A. Cari data produk asli di database berdasarkan product_id yang dikirim form
           $product = Product::findOrFail($request->product_id);

           // B. Tentukan tarif ongkos kirim otomatis berdasarkan pilihan kurir
           $shipping_cost = 15000; // Tarif dasar JNE Reguler
           if ($request->courier == 'J&T Express') {
               $shipping_cost = 20000;
           } elseif ($request->courier == 'SiCepat BEST') {
               $shipping_cost = 25000;
           }

           // C. Hitung Total Bayar: (Harga Produk x Jumlah Beli) + Ongkos Kirim
           $subtotal = $product->price * $request->quantity;
           $total_amount = $subtotal + $shipping_cost;

           // D. Buat kode Invoice unik otomatis (Contoh: INV-2026-4829)
           $invoice_code = 'INV-2026-' . rand(1000, 9999);

           // E. Simpan (INSERT) seluruh data transaksi ke dalam tabel MySQL
           $transaction = Transaction::create([
               'invoice_code'     => $invoice_code,
               'product_id'       => $product->id,
               'product_name'     => $product->name,
               'customer_name'    => $request->customer_name,
               'customer_phone'   => $request->customer_phone,
               'customer_address' => $request->customer_address,
               'courier'          => $request->courier,
               'quantity'         => $request->quantity,
               'shipping_cost'    => $shipping_cost,
               'total_amount'     => $total_amount,
               'status'           => 'Pending',
           ]);

           // F. Arahkan pembeli menuju halaman Berhasil sambil membawa ID transaksi barunya
           return redirect('/berhasil/' . $transaction->id);
       }

       // FUNGSI 5: Menampilkan halaman Invoice Berhasil berdasarkan ID Transaksi (P7)
       public function success($id)
       {
           $transaction = Transaction::findOrFail($id);
           return view('berhasil', compact('transaction'));
       }
   }
   ```

---

### LANGKAH 4: Merombak Halaman `checkout.blade.php` Menjadi Dinamis - Oleh Frontend

Sekarang kita ubah file `checkout.blade.php` hasil P4 yang tadinya statis agar menampilkan ringkasan produk yang diklik dari P6 dan mengirimkannya melalui metode `POST`.

1. Buka file `resources/views/checkout.blade.php`.
2. Ganti kode lama kalian dengan struktur formulir dinamis berikut (sesuaikan warna tombol dengan identitas Figma kelompok kalian):

   ```blade
   @extends('layouts.master')
   @section('konten_utama')

       <!-- 1. Navigasi Breadcrumb Checkout -->
       <div style="margin-bottom: 25px; font-size: 14px; color: #666;">
           <a href="/" style="color: #0B5ED7; text-decoration: none;">Katalog Utama</a>
           <span style="margin: 0 10px;">/</span>
           <a href="/detail/{{ $product->id }}" style="color: #0B5ED7; text-decoration: none;">{{ $product->name }}</a>
           <span style="margin: 0 10px;">/</span>
           <span style="color: #333; font-weight: bold;">Checkout Pesanan</span>
       </div>

       <h2 style="margin-bottom: 20px; color: #222;">Formulir Pengiriman & Pembayaran</h2>

       <div style="display: flex; gap: 30px; align-items: flex-start;">

           <!-- KOLOM KIRI: FORMULIR INPUT DATA PEMBELI -->
           <div style="width: 60%; background-color: white; padding: 25px; border-radius: 8px; border: 1px solid #ccc;">

               <!-- PENTING: Gunakan method="POST" dan arahkan action ke "/checkout/proses" -->
               <form action="/checkout/proses" method="POST">

                   <!-- WAJIB ADA: Token pengaman CSRF Laravel -->
                   @csrf

                   <!-- INPUT TERSEMBUNYI: Mengirimkan ID Produk yang sedang dibeli ke Controller -->
                   <input type="hidden" name="product_id" value="{{ $product->id }}">

                   <div style="margin-bottom: 15px;">
                       <label style="font-weight: bold; display: block; margin-bottom: 5px;">Nama Lengkap Penerima:</label>
                       <input type="text" name="customer_name" placeholder="Contoh: Budi Santoso" style="width: 96%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                   </div>

                   <div style="margin-bottom: 15px;">
                       <label style="font-weight: bold; display: block; margin-bottom: 5px;">Nomor WhatsApp / HP Aktif:</label>
                       <input type="text" name="customer_phone" placeholder="Contoh: 081234567890" style="width: 96%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                   </div>

                   <div style="margin-bottom: 15px;">
                       <label style="font-weight: bold; display: block; margin-bottom: 5px;">Alamat Lengkap Pengiriman:</label>
                       <textarea name="customer_address" rows="3" placeholder="Tuliskan Nama Jalan, RT/RW, Kecamatan, dan Kota/Kabupaten..." style="width: 96%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
                   </div>

                   <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                       <div style="width: 65%;">
                           <label style="font-weight: bold; display: block; margin-bottom: 5px;">Pilih Ekspedisi Kurir:</label>
                           <select name="courier" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: white;" required>
                               <option value="JNE Reguler">JNE Reguler (Ongkir Rp 15.000)</option>
                               <option value="J&T Express">J&T Express (Ongkir Rp 20.000)</option>
                               <option value="SiCepat BEST">SiCepat BEST (Ongkir Rp 25.000)</option>
                           </select>
                       </div>

                       <div style="width: 35%;">
                           <label style="font-weight: bold; display: block; margin-bottom: 5px;">Jumlah Beli (Qty):</label>
                           <input type="number" name="quantity" value="1" min="1" max="99" style="width: 85%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                       </div>
                   </div>

                   <button type="submit" style="background-color: #FFC107; color: black; padding: 15px; width: 100%; border: none; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">
                       Konfirmasi & Buat Pesanan Sekarang
                   </button>
               </form>
           </div>

           <!-- KOLOM KANAN: RINGKASAN PRODUK YANG DIPILIH DARI P6 -->
           <div style="width: 40%; background-color: white; padding: 25px; border-radius: 8px; border: 1px solid #ccc;">
               <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Ringkasan Pesanan</h3>

               @if($product->image)
                   <img src="{{ asset('assets/images/' . $product->image) }}" style="width: 100%; height: 180px; object-fit: cover; border-radius: 6px; margin-bottom: 15px;">
               @endif

               <h3 style="margin: 0 0 5px 0; color: #222;">{{ $product->name }}</h3>
               <p style="color: #666; font-size: 14px; margin-top: 0;">Harga Satuan Produk:</p>
               <h2 style="color: #E63946; margin-top: 0;">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>

               <hr style="margin: 15px 0; border: 0; border-top: 1px dashed #ccc;">
               <p style="font-size: 13px; color: #555; line-height: 1.5;">
                   *Total tagihan akhir (Harga Produk dikali Jumlah Beli ditambah Ongkos Kirim) akan dihitung secara otomatis oleh sistem pada halaman Invoice setelah Anda menekan tombol Konfirmasi.
               </p>
           </div>

       </div>

   @endsection
   ```

---

### LANGKAH 5: Mencetak Invoice Dinamis di Halaman `berhasil.blade.php` - Oleh Frontend

Di Pertemuan 4, halaman `berhasil.blade.php` hanya menampilkan nomor resi palsu `INV-2026-XYZ99`. Sekarang kita ubah agar mencetak rincian transaksi asli yang baru saja disimpan ke database!

1. Buka file `resources/views/berhasil.blade.php`.
2. Perbarui kodenya menjadi seperti berikut:

   ```blade
   @extends('layouts.master')
   @section('konten_utama')

       <div style="background-color: white; padding: 40px; border-radius: 8px; border: 1px solid #ccc; width: 65%; margin: 0 auto;">

           <div style="text-align: center; border-bottom: 2px dashed #ddd; padding-bottom: 20px; margin-bottom: 25px;">
               <h1 style="font-size: 55px; margin: 0;">🎉</h1>
               <h2 style="color: #28A745; margin: 10px 0 5px 0;">Transaksi Berhasil Tercatat!</h2>
               <p style="color: #666; margin: 0;">Terima kasih <strong>{{ $transaction->customer_name }}</strong>, pesanan Anda sedang kami proses.</p>
           </div>

           <!-- RINCIAN INVOICE DARI TABEL TRANSACTIONS MYSQL -->
           <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px; font-size: 15px;">
               <tr>
                   <td style="padding: 8px 0; color: #666;">Nomor Resi / Invoice:</td>
                   <td style="padding: 8px 0; text-align: right; font-weight: bold; color: #0B5ED7;">{{ $transaction->invoice_code }}</td>
               </tr>
               <tr>
                   <td style="padding: 8px 0; color: #666;">Waktu Transaksi:</td>
                   <td style="padding: 8px 0; text-align: right;">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</td>
               </tr>
               <tr>
                   <td style="padding: 8px 0; color: #666;">Produk yang Dibeli:</td>
                   <td style="padding: 8px 0; text-align: right; font-weight: bold;">{{ $transaction->product_name }} ({{ $transaction->quantity }}x)</td>
               </tr>
               <tr>
                   <td style="padding: 8px 0; color: #666;">Penerima & No. HP:</td>
                   <td style="padding: 8px 0; text-align: right;">{{ $transaction->customer_name }} ({{ $transaction->customer_phone }})</td>
               </tr>
               <tr>
                   <td style="padding: 8px 0; color: #666;">Alamat Pengiriman:</td>
                   <td style="padding: 8px 0; text-align: right;">{{ $transaction->customer_address }}</td>
               </tr>
               <tr>
                   <td style="padding: 8px 0; color: #666;">Ekspedisi & Ongkos Kirim:</td>
                   <td style="padding: 8px 0; text-align: right;">{{ $transaction->courier }} (Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }})</td>
               </tr>
               <tr>
                   <td style="padding: 8px 0; color: #666;">Status Pesanan:</td>
                   <td style="padding: 8px 0; text-align: right;">
                       <span style="background-color: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 13px;">
                           {{ $transaction->status }}
                       </span>
                   </td>
               </tr>
               <tr style="border-top: 2px solid #eee;">
                   <td style="padding: 15px 0 0 0; font-size: 18px; font-weight: bold;">TOTAL PEMBAYARAN:</td>
                   <td style="padding: 15px 0 0 0; text-align: right; font-size: 22px; font-weight: bold; color: #E63946;">
                       Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                   </td>
               </tr>
           </table>

           <div style="text-align: center; margin-top: 30px;">
               <a href="/" style="display: inline-block; background-color: #0B5ED7; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                   &larr; Kembali Belanja ke Beranda
               </a>
           </div>

       </div>
   @endsection
   ```

---

## E. ULANGI & RAYAKAN (PENGUJIAN QUALITY ASSURANCE)

Project Manager, pimpin anggota tim kalian untuk melakukan pengujian menyeluruh dari hulu ke hilir!

1. Pastikan `php artisan serve` menyala, lalu buka `http://localhost:8000` di Google Chrome.
2. **Uji Transisi Detail ke Checkout:** Pilih salah satu produk di katalog, klik **"Lihat Detail"**, lalu klik tombol hijau **"+ Masukkan Keranjang"**. Pastikan halaman berpindah mulus ke `http://localhost:8000/checkout/1` (sesuai ID barang) dan menampilkan foto serta harga barang tersebut di panel kanan.
3. **Uji Kalkulasi & Insert Transaksi:**
   - Isi Nama Lengkap, Nomor WhatsApp, dan Alamat Pengiriman.
   - Pilih kurir **J&T Express (Ongkir Rp 20.000)** dan masukkan Jumlah Beli **(Qty) = 2**.
   - Tekan tombol kuning **"Konfirmasi & Buat Pesanan Sekarang"**.
4. **Uji Halaman Invoice Dinamis:** Pastikan layar langsung berpindah ke `/berhasil/1` dan menampilkan Nomor Invoice unik, nama penerima, serta hasil hitungan matematika yang akurat: `(Harga Produk x 2) + 20.000`.
5. **Uji Keabsahan Database MySQL:** Buka tab baru `http://localhost/phpmyadmin`, klik database `ecommerce_db`, lalu klik tabel **`transactions`**. Pastikan baris pesanan yang baru saja kalian input tampil secara fisik di dalam tabel tersebut!

---

## F. FASE EKSPERIMEN KEAMANAN & SINKRONISASI TIM

Setelah alur transaksi berhasil, lakukan eksperimen teknis dan penyempurnaan berikut:

1. **Simulasi Serangan Siber (Uji Token `@csrf`):**

   Buka file `checkout.blade.php`, hapus sementara tulisan `@csrf` di dalam form, lalu simpan (*Save*). Kembali ke browser, ulangi pengisian form checkout dan klik tombol Konfirmasi. Perhatikan bagaimana Laravel langsung memblokir transaksi dengan layar peringatan **419 | PAGE EXPIRED**. Segera pasang kembali kode `@csrf` setelah kalian melihat buktinya!

2. **Simulasi Transaksi Silang Antar Produk:**

   Lakukan minimal **3 transaksi berbeda** dari 3 produk yang berbeda di katalog kalian (gunakan pilihan kurir dan jumlah beli yang bervariasi) hingga tabel `transactions` di phpMyAdmin memiliki minimal 3 baris rekaman pesanan asli.

3. **Finalisasi LKPD:**

   Project Manager memverifikasi seluruh bukti pengujian dan memandu pengisian LKPD Pertemuan 7 di bawah ini.

---

## G. KESIMPULAN & MATERI SELANJUTNYA

Luar Biasa! Hari ini siklus aplikasi *Front-Store* (Sisi Pembeli) kalian telah tuntas 100% dari awal hingga akhir! Pembeli dapat melihat katalog dinamis (P5), melihat spesifikasi detail per barang (P6), hingga melakukan pemesanan di halaman Checkout yang datanya langsung tersimpan ke dalam MySQL beserta cetakan *Invoice* resminya (P7).

**Persiapan Selanjutnya:** Saat ini data produk di toko kalian masih diinput melalui kodingan *Seeder*, dan pesanan yang masuk hanya bisa dilihat lewat *phpMyAdmin*. Pada **Pertemuan 8**, kita akan membangun **Halaman Dashboard Admin (Back-Office)** agar pemilik toko memiliki halaman khusus di web untuk memantau daftar pesanan yang masuk dan menambah produk baru langsung melalui antarmuka aplikasi!

---

## H. LEMBAR KERJA PESERTA DIDIK (LKPD) - PERTEMUAN 7

### INSTRUMEN PENGUJIAN TRANSAKSI CHECKOUT, CSRF, & INSERT DATABASE

### A. IDENTITAS PROYEK KELOMPOK

- Nama Merek / Toko : .........................................................................
- Sektor E-Commerce : .........................................................................
- Pembagian Peran Pengujian :
  1. Project Manager : .........................................................................
  2. UI/UX Designer : .........................................................................
  3. Backend Developer : .........................................................................

### B. CHECKLIST KONFIGURASI DATABASE, ROUTING, & FORMULIR

*(Wajib dicentang oleh Project Manager setelah melihat langsung pekerjaan tim)*

| No | Instruksi Kerja Fungsional (SOP) | Status | TTD PM |
|---|---|---|---|
| 1 | **Migration & Model:** Tabel `transactions` terbentuk di MySQL dan `Transaction.php` telah memiliki `protected $guarded = [];`. | [ ] | ............... |
| 2 | **Routing Setup:** File `web.php` telah memiliki rute `GET /checkout/{id}`, `POST /checkout/proses`, dan `GET /berhasil/{id}`. | [ ] | ............... |
| 3 | **Form & Security:** File `checkout.blade.php` telah menggunakan `method="POST"`, direktif `@csrf`, dan input tersembunyi `product_id`. | [ ] | ............... |
| 4 | **Controller & Invoice:** Fungsi `storeTransaction` berhasil menghitung ongkir, menyimpan ke DB, dan mencetak *Invoice* di `berhasil.blade.php`. | [ ] | ............... |

### C. MATRIKS PENGUJIAN ALUR TRANSAKSI & KEAMANAN (QUALITY ASSURANCE)

*(Eksekusi di peramban Google Chrome dan tandai status kelulusannya)*

| Skenario Pengujian Sistem Terpadu | Target yang Diharapkan (Expected Result) | Status Kelulusan |
|---|---|---|
| **Uji Integrasi Tombol P6 ke Checkout** | Mengklik tombol "+ Masukkan Keranjang" di halaman Detail berhasil membuka `/checkout/{id}` dengan data produk yang sesuai. | [ ] PASS [ ] FAIL |
| **Uji Kalkulasi Matematika Transaksi** | Memilih kurir berbeda dan mengubah jumlah beli (*Qty* > 1) menghasilkan angka **Total Pembayaran** yang akurat di halaman Invoice. | [ ] PASS [ ] FAIL |
| **Uji Rekam Data Permanen (MySQL)** | Minimal 3 transaksi percobaan berhasil masuk dan tercatat lengkap di tabel `transactions` pada *phpMyAdmin*. | [ ] PASS [ ] FAIL |
| **Uji Proteksi Keamanan CSRF** | Menghapus sementara `@csrf` pada form dan menekan tombol submit ditolak oleh server dengan layar **419 PAGE EXPIRED**. | [ ] PASS [ ] FAIL |

### D. DOKUMENTASI VALIDASI TANGKAPAN LAYAR (SCREENSHOT)

#### 1. Bukti Halaman Formulir Checkout Dinamis (`/checkout/{id}`)

*(Tempel di sini - Pastikan bilah URL, isian form pembeli, dan ringkasan produk di sebelah kanan terlihat jelas)*

#### 2. Bukti Halaman Invoice Transaksi Berhasil (`/berhasil/{id}`)

*(Tempel di sini - Pastikan Nomor Resi INV-2026-XXXX, rincian ongkir, dan Total Pembayaran terlihat jelas)*

#### 3. Bukti Rekaman Tabel `transactions` di phpMyAdmin

*(Tempel di sini - Menampilkan tabel `transactions` di phpMyAdmin yang sudah terisi minimal 3 baris pesanan)*

### E. JURNAL PEMECAHAN MASALAH ANALITIS (TROUBLESHOOTING)

**Studi Kasus Arsitektur & Keamanan Transaksi:**

1. Pada `checkout.blade.php`, kita mengirimkan `product_id` menggunakan `<input type="hidden">`, lalu di `ProductController.php` Backend mengambil ulang harga asli produk dari database (`$product = Product::findOrFail($request->product_id)`). Mengapa kita **tidak disarankan** mengambil harga barang langsung dari input form HTML biasa saat menghitung total pembayaran di *Controller*? Apa bahayanya bagi bisnis toko online jika pembeli bisa mengutak-atik elemen HTML (*Inspect Element*) di browser?

**Jawab:**

.....................................................................................................................................................

---

Mengetahui / Mengesahkan,

Guru Mata Pelajaran Pemrograman Web,

&nbsp;

**( Sulthan Alawy Shihab, S.Kom )**
