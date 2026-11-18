# LEMBAR KERJA PESERTA DIDIK (LKPD)

## PERTEMUAN 12

INSTRUMEN PENGUJIAN AUTENTIKASI LOGIN, LOGOUT, & PROTEKSI MIDDLEWARE (auth)

## A. IDENTITAS PROYEK KELOMPOK

Nama Merek / Toko : .........................................................................

Sektor E-Commerce : .........................................................................

Pembagian Peran Pengujian :

Project Manager (QC Lead) : .........................................................................

UI/UX Designer (Frontend) : .........................................................................

Backend Developer (DB) : .........................................................................

B. CHECKLIST KONFIGURASI KEAMANAN & AUTENTIKASI(Wajib dicentang oleh Project Manager setelah melihat langsung pekerjaan tim)

| No | Instruksi Kerja Fungsional (SOP) | Status | TTD PM |

| --- | --- | --- | --- |

| 1 | Admin User Seeding: Akun admin resmi berhasil ditanamkan ke tabel users dengan enkripsi Hash::make(). | [ ] | ............... |

| 2 | Middleware Route Group: Seluruh rute /admin/... di web. telah dibungkus di dalam Route::middleware(['auth'])->group(...). | [ ] | ............... |

| 3 | Login UI & Show/Hide Password: Halaman auth/login.blade., tombol Lihat Password, dan Auth::attempt() berjalan akurat. | [ ] | ............... |

| 4 | Smart Header & Logout: Direktif @auth di master.blade. dan tombol Keluar di admin.blade. berfungsi mengunci sesi. | [ ] | ............... |

C. MATRIKS PENGUJIAN KEAMANAN AKSES (QUALITY ASSURANCE)(Eksekusi di peramban Google Chrome dan tandai status kelulusannya)

| Skenario Pengujian Sistem Terpadu | Target yang Diharapkan (Expected Result) | Status Kelulusan |

| --- | --- | --- |

| Uji Cegat Penyusup Tanpa Login (middleware) | Mengakses /admin/transactions atau /admin/products saat belum login otomatis dialihkan paksa ke /login. | [ ] PASS   <br>[ ] FAIL |

| Uji Proteksi Kredensial Salah | Memasukkan password yang salah di form /login berhasil ditolak dan menampilkan pesan peringatan kesalahan. | [ ] PASS   <br>[ ] FAIL |

| Uji Keberhasilan Login Resmi & Smart Header | Login dengan akun benar membuka Seller Center, menampilkan nama Admin, dan mengubah tombol di beranda toko. | [ ] PASS   <br>[ ] FAIL |

| Uji Keamanan Logout & Kunci Ulang | Setelah klik tombol "Keluar", mencoba mengakses kembali halaman /admin/... kembali ditolak dan diarahkan ke /login. | [ ] PASS   <br>[ ] FAIL |

## D. DOKUMENTASI VALIDASI TANGKAPAN LAYAR (SCREENSHOT)

1. Bukti Halaman Login Seller Center (/login) & Pesan Penolakan Saat Password Salah(Tempel di sini - Menampilkan antarmuka halaman Login kelompok kalian beserta uji coba penolakan password salah)

2. Bukti Masuk ke Seller Center (Menampilkan Nama Admin Aktif & Tombol Keluar di Pojok Kanan Atas)(Tempel di sini - Pastikan bilah navigasi atas menampilkan nama Admin yang sedang login dan notifikasi sambutan)

3. Bukti Enkripsi Password (Bcrypt Hash) di Tabel users pada MyAdmin(Tempel di sini - Tampilkan isi tabel users di MyAdmin yang membuktikan kolom password berisi kode hash acak $2y$..., bukan teks biasa)

## E. JURNAL PEMECAHAN MASALAH ANALITIS (TROUBLESHOOTING)

Studi Kasus Arsitektur Keamanan & Middleware:

Mengapa di dalam file routes/web. kita hanya memasang pelindung Route::middleware(['auth']) pada kelompok rute /admin/... saja, sedangkan rute /, /detail/{id}, dan /checkout/{id} dibiarkan berada di luar grup Middleware tersebut? Apa dampak buruknya bagi bisnis toko online jika rute / dan /detail/{id} tidak sengaja ikut dimasukkan ke dalam grup middleware('auth')?

Mengapa kata sandi di dalam DatabaseSeeder. wajib dibungkus menggunakan perintah Hash::make('admin123') dan tidak boleh ditulis langsung 'password' => 'admin123'?

Jawab: ............................................................................................................................................................................................................................................................................................................

Mengetahui / Mengesahkan,

Guru Mata Pelajaran Pemrograman Web,

( Sulthan Alawy Shihab, S.Kom )